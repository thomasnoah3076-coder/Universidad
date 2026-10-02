# AGENTS.md

Instrucciones para agentes de IA. Precedencia (CONSTITUTION Art. 11): `CONSTITUTION.md` > instrucciones directas del usuario > este archivo > `MEMORY.md`. Lee los tres al inicio. `MEMORY.md` guarda el esquema detallado (§3), supuestos (§4) e inconsistencias abiertas (§5). Idioma: español (CONSTITUTION Art. 9).

## 1. Verificado en el repositorio (2026-10-01)

- **Laravel 13.30.1 / PHP 8.3** (`composer.json`: `laravel/framework ^13.0`). El material de clase dice Laravel 12: gana Laravel **13**; verifica cualquier API dudosa en `composer.json`/`composer.lock`/docs de Laravel 13.
- **Dominio implementado hoy:** universidad — `students`, `clubs`, `enrollments` (+ tablas base de Laravel). Modelos en `app/Models`, migraciones en `database/migrations` (todas aplicadas; comprueba con `php artisan migrate:status`).
- **El dominio de facturación (Unidad Temática II) NO existe aún**: no hay migraciones ni modelos de `productos`, `clientes`, `facturas`, etc. Es el foco actual de trabajo (D-002 en `MEMORY.md`). El documento de clase no está en el repo: su transcripción vive en este archivo y en `MEMORY.md`.
- **Factories/seeders reales:** `StudentFactory` implementada; `ClubFactory` y `EnrollmentFactory` son stubs vacíos; solo existe `DatabaseSeeder` (crea 10 usuarios).
- **Tests:** Pest 4, estilo `test()`/`expect()`; corren en **sqlite `:memory:`** (`phpunit.xml`), no en la BD de `.env`. En `tests/Pest.php` el `RefreshDatabase` está **comentado**: un test de Feature que toque BD debe añadirlo (`->use(RefreshDatabase::class)` o el trait) o fallará.
- **No hay CI**, ni scripts de lint/typecheck. Frontend: Vite construye solo `resources/sass/app.scss` (Bootstrap 5) y `resources/js/app.js` (`vite.config.js`); `resources/css/app.css` (Tailwind) **no** está en el build — `welcome.blade.php` carga Tailwind por CDN.
- **BD:** `.env.example` trae `DB_CONNECTION=sqlite`; el material de clase usa MySQL. No asumas el motor: revisa `.env.example` y `phpunit.xml`. **Nunca leas `.env`** (solo `.env.example`).
- Laravel Boost ya está instalado: MCP en `opencode.json`; `CLAUDE.md` es su bootstrap, ya superado por este archivo.

## 2. Comandos verificados

```bash
composer setup                # install + .env + key:generate + migrate + npm install + build
composer dev                  # serve + queue + vite (concurrently)
php artisan test              # o: composer test (config:clear + test)
php artisan test tests\Unit\ExampleTest.php   # un solo archivo
php artisan migrate:status
php artisan migrate --pretend               # SQL sin ejecutar
php artisan tinker                           # probar: Modelo::factory()->make()
php vendor\bin\pint <archivo>               # formatear un archivo
```

- **Pint** (sin `pint.json` → preset por defecto): `pint --test` ya falla en ~13 archivos preexistentes. Formatea **solo los archivos que tocaste**; no hagas correcciones masivas fuera de alcance (CONSTITUTION Art. 5).
- **Destructivos** (`migrate:fresh`/`reset`/`refresh`/`rollback`, `db:wipe`, `migrate --force`, `DROP`/`TRUNCATE`/`DELETE` sin `WHERE`): requieren confirmación explícita e informar entorno y qué datos se pierden (CONSTITUTION Art. 3). Nunca en producción.
- Seguros: `php artisan make:migration|make:model|make:factory XFactory --model=X|make:seeder`, `php artisan migrate`, `php artisan db:seed --class=XSeeder`.

## 3. Convenciones del código real (difieren de los defaults)

- Los modelos usan **atributos PHP** en vez de propiedades: `#[Fillable([...])]`, `#[Hidden([...])]` (ver `app/Models/Student.php`), más `protected $table` explícito y relaciones con tipo de retorno.
- Las factories existentes usan `$this->faker`; `fake()` también funciona, pero **no mezcles ambos** en el mismo archivo.
- Dominio universidad: esquema en **inglés** (`first_name`, `degree_program`, `status` enum). Dominio facturación: nombres en español **tal cual** (`registradopor`, `tipopago`, `saldopendiente`, `fechapago`); no los "corrijas".
- El nombre de clase debe coincidir exacto con archivo y `use` (el autoload distingue mayúsculas). Casing decidido: `Detallefactura`, `MetodoPago` (D-003).
- `routes/web.php` registra `Auth::routes()` y `/home` **tres veces** (scaffolding `laravel/ui`). Duplicado conocido: no lo toques sin pedirlo.
- Tablas: plural minúscula; FK `<entidad>_id`; columnas `snake_case`.

## 4. Dominio facturación (objetivo, aún sin crear)

| Tabla | Columnas (además de `id` y `timestamps`) |
|---|---|
| `productos` | `nombre`, `precio_venta` dec(8,2), `precio_compra` dec(8,2), `descripcion` text null, `stock` int, `imagen`, `estado`, `registradopor` |
| `clientes` | `nombre`, `direccion`, `telefono`, `email` único, `estado`, `registradopor` |
| `facturas` | `fecha` date, `total` dec(10,2), `cliente_id` FK, `tipopago`, `saldopendiente` dec(10,2) null, `estado`, `registradopor` |
| `detallefacturas` | `factura_id` FK (cascade), `producto_id` FK, `cantidad` int, `subtotal` dec(10,2), `registradopor` |
| `metodopagos` | `nombre`, `descripcion` text null, `estado`, `registradopor` |
| `pagos` | `factura_id` FK (cascade), `fechapago` date, `monto` dec(10,2), `metodopago_id` FK (restrict), `estado`, `registradopor` |

Relaciones (`MEMORY.md` §3): Cliente 1—N Factura · Factura 1—N Detallefactura · Producto 1—N Detallefactura · Factura 1—N Pago · MetodoPago 1—N Pago. Reglas que condicionan migraciones/factories/seeders:

- `saldopendiente` = `total` − suma de `pagos.monto`; en contado vale `0`; nunca mayor que `total` ni negativo.
- `subtotal` de un detalle = `cantidad` × `precio_venta` (si el factory usa precio aleatorio, anótalo en `MEMORY.md` §5).
- `estado` es string `'1'` = activo; `tipopago` usa `contado`/`crédito` (S-003/S-004, por confirmar). Sé consistente en factories, seeders y validaciones.
- `estado` y `registradopor` son NOT NULL sin default en todas las tablas (excepto `detallefacturas`, que no tiene `estado`): todo `create()`/factory/seeder debe rellenarlos.
- Un método de pago tiene muchos pagos; **un pago tiene un solo método**.

Reglas de migraciones, modelos, factories y seeders:

- Migraciones: estilo moderno `return new class extends Migration` con `up(): void`/`down()` (el `down()` revierte exactamente el `up()`); FK con `foreignId('x')->constrained()`; `string('campo')` **siempre entre comillas**; `decimal` para dinero, nunca `float`. Cambios a tablas existentes: **nueva migración con `Schema::table()`**; nunca editar una ya ejecutada.
- Antes de escribir un factory o seeder, **abre la migración** de esa tabla y copia los nombres de columna: cada clave del array debe ser una columna real.
- Factories: una clase por archivo; relaciones con `Modelo::factory()`; no llames `create()` dentro de `definition()`; datos coherentes con las reglas de negocio de arriba.
- Seeders: `DatabaseSeeder` llama a los demás con `$this->call([...])`; orden por FK: `MetodoPago` → `Producto` → `Cliente` → `Factura` → `Detallefactura` → `Pago`. Reinicio local: `migrate:fresh --seed` (destructivo).
- Supuestos nuevos → `MEMORY.md` §4; inconsistencias abiertas → `MEMORY.md` §5.

## 5. Discrepancias del documento de clase (no las repitas)

| El documento dice / hace | Hacer aquí |
|---|---|
| "Laravel 12" | Laravel **13** |
| Migraciones `class CreateXTable extends Migration` | `return new class extends Migration` |
| `string(imagen)`, `decimal(saldopendiente,10,2)` sin comillas | Siempre comillas |
| `precio_unitario` en `$fillable` sin columna | Quitarlo o crear migración (decidir con el usuario) |
| Factories/seeder con `fecha_pago`, `saldo_pendiente` | Columnas: `fechapago`, `saldopendiente` |
| `DetalleFactura` / `Metodopago` | `Detallefactura` / `MetodoPago` |
| `create()` de detalle/pago sin `registradopor`/`estado` | Incluirlos (NOT NULL) |
| `for ($i=0; $i<rand(1,5); $i++)` | Calcula `rand` una vez fuera del bucle |
| `rand(50, $saldo)` | Falla si `$saldo < 50`; usa `min`/`max` seguros |
| "Un pago puede tener varios métodos" | Un método → muchos pagos; un pago → un método |
| `migrate --isolated` = "transacción aislada" | Es un lock entre instancias, no una transacción. Ver docs Laravel 13 |
| Ejemplo de `config/database.php` con defaults `'forge'` | No copiarlo: solo configura `.env.example`/`.env` |
| Texto dice 10 clientes/20 productos o "10 métodos", código `count(3)` | Manda el código |

## 6. Flujo de trabajo

1. Lee `CONSTITUTION.md`, este archivo y `MEMORY.md`.
2. Revisa el estado real: `composer.json`, migraciones, modelos, `.env.example`.
3. Cambio mínimo pedido; sin refactorizar lo demás (CONSTITUTION Art. 5).
4. Verifica y reporta lo que **comprobaste** vs lo que **supones** (CONSTITUTION Art. 2 y 7): `migrate --pretend`, `Modelo::factory()->make()` en tinker, `php artisan test`, pint solo en archivos tocados.
5. Registra decisiones/supuestos en `MEMORY.md` (no borres entradas; marca `[OBSOLETO]`).
6. Al terminar: qué cambió, cómo se verificó, qué quedó pendiente/sin verificar.
