# MEMORY.md

Memoria persistente del proyecto para agentes de IA. Contiene decisiones, supuestos y estado conocidos.

**Cómo usarla**
- Léela al iniciar cada sesión, después de `CONSTITUTION.md` y `AGENTS.md`.
- **Agrega, no borres.** Si algo cambia, añade una entrada nueva que reemplace a la anterior y marca la vieja como `[OBSOLETO]`.
- Registra solo hechos confirmados por el usuario o verificados en el código. Lo que sea suposición va en "Supuestos" y se marca como tal.
- No guardes secretos, contraseñas ni datos personales.

---

## 1. Decisiones vigentes

| ID | Fecha | Decisión | Origen |
|---|---|---|---|
| D-001 | 2026-10-01 | El proyecto usa **Laravel 13**. El material de clase dice Laravel 12; esa mención es un error de versión y no debe seguirse. | Indicado por el usuario |
| D-002 | 2026-10-01 | Los agentes trabajan con el tema **Base de Datos en Laravel** (migraciones, modelos, factories, seeders), con foco actual en **factories**. | Indicado por el usuario |
| D-003 | 2026-10-01 | Casing oficial de clases: `Detallefactura` y `MetodoPago`. | Derivado de los modelos del documento; confirmar con el usuario |
| D-004 | 2026-10-01 | Las migraciones siguen el esquema del documento tal cual (nombres como `registradopor`, `tipopago`, `saldopendiente`, `fechapago`). Los factories y seeders se adaptan a las migraciones, no al revés. | Derivado del documento; confirmar con el usuario |
| D-005 | 2026-10-01 | [OBSOLETO] Siembra de `StudentSeeder` (10) y `ClubSeeder` (10) llamados desde `DatabaseSeeder`; el `president_id` de cada club es un **student existente aleatorio** (no crea students extra). Verificación sin borrar datos (`db:seed --class=...`). | Elegido por el usuario |
| D-006 | 2026-10-01 | Los seeders de students y clubs se **eliminaron**: la siembra va inline en `DatabaseSeeder` con líneas de código (`Student::factory(10)->create()` y `Club::factory(10)->create()`). El `president_id` aleatorio de D-005 sigue vigente (está en `ClubFactory`). | Solicitud del usuario |
| D-007 | 2026-10-22 | Frontend sobre **AdminLTE 3.2.0 / Bootstrap 4.6.1** servido desde `public/backend/` con `asset()`; **sin Vite y sin CDN**. El tema propio vive en `public/css/universidad.css` y la confirmación de borrado en `public/js/universidad.js`. | Solicitud del usuario + verificación de versión |
| D-008 | 2026-10-22 | La relación N:M Student↔Club se gestiona desde el **formulario de Club** con un multi-select de estudiantes que sincroniza `enrollments` (nuevos con `status = 'active'`). **No se añadió `belongsToMany`** a los modelos: se usa `$club->enrollments()`. | Decisión del usuario |
| D-009 | 2026-10-22 | CRUD de `students` y `clubs` detrás del middleware `auth`; la página de inicio es `/home` con conteos reales. | Decisión del usuario |
| D-010 | 2026-10-22 | El nombre visible del proyecto es **"Universidad"**, fijo en `layouts/app.blade.php` (no se usa `config('app.name')`). | Decisión del usuario |
| D-011 | 2026-10-22 | Identidad visual propia sobre AdminLTE: dirección **registro académico / libro de actas** (tinta `#17242e`, papel frío `#eef1ef`, reglas finas y acento oxblood `#8c3f3f`; serif en títulos, cifras y nombres de registro). Login partido (portada + formulario), inicio tipo *ledger* y tablas sin columnas secundarias en móvil. Sin paquetes nuevos ni CDN. | Solicitud del usuario ("continua con el diseño") |
| D-012 | 2026-10-22 | Las pantallas públicas de acceso (`welcome`, `login`, `register`, confirmación de contraseña y verificación) comparten la portada institucional del partial `layouts/partials/auth-ledger.blade.php` y el layout `app_authentication`. `/` ya no usa Tailwind por CDN. | Continuidad visual de D-011 |
| D-013 | 2026-10-23 | [OBSOLETO] Habilitó la verificación de correo (`MustVerifyEmail`, `Auth::routes(['verify' => true])` y `verified`). El usuario pidió volver al comportamiento anterior, así que quedó **desactivada** y las rutas volvieron a `auth` simple. | Solicitud del usuario ("Dejalo tal cual como estaba antes de la verficación de email") |
| D-014 | 2026-10-23 | En `clubs`, `status` vale `true` al crearse y `registered_by` es el id del usuario autenticado que registra el club. Ambos quedan en `#[Fillable]`; `registered_by` no se edita desde el formulario. | Solicitud del usuario ("solo vas a hacer estos pendientes") |
| D-015 | 2026-10-23 | Las rutas de verificación de correo están **registradas de nuevo** (`Auth::routes(['verify' => true])`), pero **no se exigen** en `students` ni en `clubs`; esos recursos siguen con `auth` simple. La vista `auth/verify` queda disponible si se quiere usar el flujo sin bloquear el CRUD. | Solicitud del usuario ("no queria que borraras las rutas...") |

## 2. Contexto del proyecto

- Fuente: documento *Unidad Temática II – Base de Datos (Database)*, Framework Laravel.
- Dominio ejemplo: tienda/sistema de ventas con `Producto`, `Cliente`, `Factura`, `Detallefactura`, `MetodoPago`, `Pago`.
- Base de datos de referencia: MySQL, configurada vía `.env` (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- Estado de implementación real (qué migraciones, modelos, factories y seeders existen ya): **[OBSOLETO 2026-10-22]** decía "no verificado". Verificado: 7 migraciones aplicadas; modelos `Student`, `Club`, `Enrollment`, `User`; factories `StudentFactory`, `ClubFactory`, `EnrollmentFactory`, `UserFactory`; siembra inline en `DatabaseSeeder`. Datos locales: 20 students, 20 clubs, 200 enrollments, 11 users.

## 3. Esquema vigente (resumen)

```
productos(id, nombre, precio_venta, precio_compra, descripcion?, stock, imagen, estado, registradopor, timestamps)
clientes(id, nombre, direccion, telefono, email UNIQUE, estado, registradopor, timestamps)
facturas(id, fecha, total, cliente_id→clientes, tipopago, saldopendiente?, estado, registradopor, timestamps)
detallefacturas(id, factura_id→facturas CASCADE, producto_id→productos, cantidad, subtotal, registradopor, timestamps)
metodopagos(id, nombre, descripcion?, estado, registradopor, timestamps)
pagos(id, factura_id→facturas CASCADE, fechapago, monto, metodopago_id→metodopagos RESTRICT, estado, registradopor, timestamps)
```

`?` = nullable. `estado` y `registradopor` son strings NOT NULL sin default.

Relaciones: Cliente 1—N Factura · Factura 1—N Detallefactura · Producto 1—N Detallefactura · Factura 1—N Pago · MetodoPago 1—N Pago.

## 4. Supuestos de base de datos

Los supuestos nacen de vacíos en el análisis de requerimientos y deben quedar documentados.

| ID | Supuesto | Fundamento | Estado |
|---|---|---|---|
| S-001 | Existen ventas a crédito; por eso hay `tipopago`, `saldopendiente`, `metodopagos` y `pagos`. | Entrevista, observación de caja y campo "saldo pendiente" en la factura (ejemplo del documento) | Confirmado por el documento |
| S-002 | `saldopendiente = total − suma de pagos`; en ventas de contado vale 0. | Regla derivada de S-001 | Por confirmar |
| S-003 | `estado` se almacena como string (`'1'` = activo). | Valor usado en los factories del documento | Por confirmar |
| S-004 | `tipopago` toma los valores `contado` y `crédito`. | Factory de `Factura` del documento | Por confirmar (decidir si con o sin tilde) |
| S-005 | Fragmento del usuario `product_id`/`supplier_id` interpretado como `student_id`/`club_id` en `EnrollmentFactory`. No existen modelos `Product`/`Supplier` y `enrollments` solo tiene esas dos FK. | Migración `2026_09_18_create__enrollments_table`; avisado al usuario | Adaptado 2026-10-01 |
| S-006 | `clubs.status` y `clubs.registered_by` se muestran en la ficha (estado) pero **no se editan** desde el CRUD, porque no están en el `#[Fillable]` del modelo y no se quiso modificar el modelo. `registered_by` queda `null`. | Decisión de alcance 2026-10-22; requiere cambio de modelo para editarse | Por confirmar |
| S-007 | Las fechas (`date_of_birth`, `registration_date`, `foundation_date`, `enrollment_date`) se formatean con `Carbon::parse()` en Blade porque los modelos no declaran `casts` de fecha. | Modelos sin `casts()`; evita cambiar modelos | Confirmado en código |

## 5. Inconsistencias abiertas (requieren decisión del usuario)

1. `Detallefactura`: el `$fillable` del documento incluye `precio_unitario`, pero la migración no tiene esa columna. ¿Se agrega la columna o se quita del `$fillable`?
2. Los factories/seeders del documento usan `fecha_pago` y `saldo_pendiente`; las migraciones usan `fechapago` y `saldopendiente`. Decisión provisional: mandan las migraciones (D-004).
3. El seeder de ejemplo no llena `registradopor`/`estado` en `Detallefactura::create` y `Pago::create`, columnas NOT NULL: fallaría. Hay que corregirlo al implementarlo.
4. Valor `crédito` con tilde en `tipopago`: ¿se mantiene?
5. Detalle por producto: el `subtotal` del factory no usa el `precio_venta` real del producto. ¿Se requiere coherencia exacta?

## 6. Glosario

- **Migración:** archivo en `database/migrations` que define/modifica la estructura de la BD de forma versionada.
- **Eloquent / Modelo:** ORM de Laravel; clase en `app/Models` que representa una tabla.
- **Factory:** clase en `database/factories` que define cómo generar datos falsos para un modelo.
- **Seeder:** clase en `database/seeders` que puebla la BD; `DatabaseSeeder` es el punto de entrada.
- **Faker / `fake()`:** librería de datos falsos; en el proyecto se prefiere el helper `fake()`.
- **MER:** modelo entidad-relación (entidades, atributos, relaciones 1:1, 1:N, N:M).
- **Normalización:** organizar tablas para eliminar redundancia e inconsistencias.

## 7. Registro de cambios

Formato: `AAAA-MM-DD | quién (agente/usuario) | qué cambió | por qué`

- 2026-10-01 | agente | Creación de AGENTS.md, MEMORY.md y CONSTITUTION.md a partir de la Unidad Temática II; registrada la decisión D-001 (Laravel 13) | Solicitud del usuario
- 2026-10-01 | agente | `ClubFactory` implementado; creados `StudentSeeder` y `ClubSeeder` (10 registros c/u) y conectados a `DatabaseSeeder`; D-005 | Solicitud del usuario
- 2026-10-01 | agente | Eliminados `StudentSeeder`/`ClubSeeder`; siembra inline en `DatabaseSeeder` (D-006) | Solicitud del usuario
- 2026-10-01 | agente | `EnrollmentFactory` completado con FKs aleatorias adaptadas (S-005); `DatabaseSeeder` ahora siembra 10 users, 20 students, 20 clubs, 200 enrollments; BD local llevada a ese mismo estado | Solicitud del usuario
- 2026-10-16 | agente | `localhost:8000` devolvía **HTTP 500** en `/`: `welcome.blade.php` usa `route('register')`/`route('login')` pero los tres `Auth::routes();` de `routes/web.php` estaban comentados. Se reactivó **uno** (los otros dos siguen comentados, duplicado conocido de AGENTS.md §3). Verificado: `/`, `/login`, `/register` → 200; `/dashboard` → 302 a `/login` | Solicitud del usuario ("revisar por qué no funciona")
- 2026-10-16 | agente | Creado `AdminController` (`dashboard()`, `settings()`, tipos de retorno `View`) + vistas `dashboard.blade.php`/`settings.blade.php` sobre `layouts.app` (misma convención que `home.blade.php`); rutas `/dashboard` y `/settings` **sin** middleware en el constructor porque el grupo `Route::middleware(['auth'])` ya lo aplica, y con `->name(...)` (necesario para los `route()` de las vistas). `pint` aplicado a los archivos tocados. Verificado: `route:list` OK, `php artisan test` 4 passed / 10 assertions, curl: `/dashboard` y `/settings` → 302 a `/login` (invitado), 200 autenticado (vía test) | Solicitud del usuario ("corrige estos dos errores")
- 2026-10-22 | agente | Frontend AdminLTE v3 completo: layout reescrito (sin `@vite`, sin CDN, assets locales, scripts antes de `</body>`), sidebar con menú Inicio/Estudiantes/Clubes y `routeIs()`, topbar con `@auth`, footer con año; partials nuevos `page-header`, `alerts`, `status-badge`; tema `public/css/universidad.css`; CRUD de `students` y `clubs` (controladores + 10 vistas) con multi-select Select2 de estudiantes hacia `enrollments`; `/home` con conteos reales; `HomeController` ahora pasa los totales; login usa monograma (el PNG `logo_audysoft.png` no existía). Se eliminó la dependencia de `@vite` que causaba **HTTP 500** (manifest ausente) | Solicitud del usuario
  - Verificado: `route:list` = 33 rutas (14 nuevas `students.*`/`clubs.*`); `php artisan test` = **11 passed / 37 assertions** (antes 1 failed por Vite); render de las 11 vistas vía tinker OK; servidor en `:8123`: `/` y `/login` 200, `/home`, `/students`, `/clubs` 302 a login, todos los assets (AdminLTE, jQuery, Bootstrap 4, Font Awesome, Select2, CSS/JS propios) 200; `pint` en los 5 PHP tocados.
  - Supuestos: `clubs.status` y `clubs.registered_by` no son `fillable`, así que se muestran pero no se editan (S-006). Las fechas se muestran con `Carbon::parse()` en Blade porque los modelos no tienen `casts` de fecha (S-007).
- 2026-10-22 | agente | Pasada de diseño (D-011): tema reescrito con tokens de tinta/papel/oxblood y serif local; login partido; inicio tipo *ledger*; se superó por especificidad el activo azul de AdminLTE; `code` con fondo propio; paginación vacía oculta; barra superior muestra "Universidad" también en móvil; columnas secundarias de las tablas ocultas bajo `md`; `lang="es"` en ambos layouts | Solicitud del usuario ("continua con el diseño")
  - Verificado visualmente con Firefox headless (escritorio 1440x1000 y móvil 390x844) sobre login, inicio, listados, ficha y edición de club. Las vistas autenticadas se generaron con un test temporal en sqlite `:memory:` y se sirvieron desde `public/__preview`; **ambos artefactos se eliminaron** al terminar.
  - Se reconstruyeron `auth/passwords/email` y `auth/passwords/reset` con el layout de acceso y se corrigió la acción del formulario de `password.request` a `password.update`; antes el enlace "¿Olvidaste tu contraseña?" llevaba a una tarjeta con el logo inexistente y el POST apuntaba a la ruta equivocada. Verificado por HTTP y captura.
  - Verificado técnicamente: `php artisan test` = **11 passed / 37 assertions**; `php artisan view:cache` y `view:clear` OK. No se tocaron migraciones, modelos ni datos reales.
- 2026-10-22 | agente | Segunda pasada de diseño (D-012): parcial `auth-ledger` reutilizado en welcome/login/register/confirm/verify; `/` reconstruida sin Tailwind por CDN; registro y confirmación de contraseña pasados a `layouts.app_authentication`; `verify` traducido y con el reenvío protegido por `Route::has('verification.resend')`; `dashboard` y `settings` traducidos (Panel/Configuración) y con contenido coherente; `AdminRoutesTest` actualizado a los títulos en español | Solicitud del usuario ("Continua")
  - Verificado visualmente con Firefox headless en escritorio (1440x1000) y móvil (390x844) sobre `/`, login, registro, confirmación de contraseña, dashboard y configuración. Las vistas autenticadas se generaron con un test temporal en sqlite `:memory:` y se sirvieron desde `public/__preview`; **el test y el directorio se eliminaron** al terminar.
  - Verificado por HTTP en `:8010`: `/`, `/login`, `/register`, `/password/reset` → 200; `/password/confirm` (invitado) → 302 a login. `php artisan test` = **11 passed / 37 assertions**; `view:cache` y `view:clear` OK.
  - Pendiente de decisión: `auth/verify` sigue sin rutas activas porque `User` no implementa `MustVerifyEmail`; no se habilitó la verificación. El duplicado `auth/passwords/register.blade.php` se eliminó el 2026-10-23.
- 2026-10-23 | agente | Limpieza final: eliminado `resources/views/auth/passwords/register.blade.php`, un duplicado no usado del registro con logo inexistente y HTML mal cerrado; ninguna ruta ni vista lo referenciaba | Cierre del pendiente dejado en la segunda pasada
  - Verificado con `grep`: sin referencias a `auth.passwords.register` ni a `logo_audysoft`. `php artisan test` = **11 passed / 37 assertions**; `view:cache` y `view:clear` OK.
- 2026-10-23 | agente | Verificación de correo habilitada (D-013): `User` implementa `MustVerifyEmail`; `Auth::routes(['verify' => true])`; rutas de administración con `auth + verified`; `/home` con `auth + verified`; nuevo `EmailVerificationTest`. Un usuario no verificado cae en `/email/verify` | Solicitud del usuario ("continua con lo que habia quedado pendiente")
  - Verificado con `route:list`: `verification.notice`, `verification.verify` y `verification.resend` activos; `Mail` en `log` según `.env.example`, comportamiento igual al resto del proyecto. `php artisan test` = **14 passed / 48 assertions**. `view:cache` y `view:clear` OK.
  - Verificado visualmente en escritorio y móvil con una captura temporal de `/email/verify` servida desde `public/__preview`; el artefacto se eliminó al terminar.
- 2026-10-23 | agente | `clubs.status` y `clubs.registered_by` resueltos (D-014): añadidos a `#[Fillable]`, `status => true` por defecto al crear y `registered_by` con el id del usuario autenticado. `Club::casts()` incluye `foundation_date` y `status`. Se prueba con `StudentClubCrudTest` | Solicitud del usuario ("solo vas a hacer estos pendientes")
  - Verificado con `php artisan test tests/Feature/StudentClubCrudTest.php` = **7 passed / 29 assertions** y con la suite completa = **14 passed / 50 assertions**. No se tocaron migraciones ni factories.
- 2026-10-23 | agente | Revertida la verificación de correo (D-015): `User` deja de implementar `MustVerifyEmail`; `Auth::routes()` vuelve a la versión sin `verify`; `/home` y las rutas protegidas vuelven a `auth` simple; eliminado `EmailVerificationTest`. Un usuario ya registrado vuelve a entrar sin `/email/verify` | Solicitud del usuario ("Dejalo tal cual como estaba antes de la verficación de email")
  - Verificado con `route:list`: ya no hay rutas `verification.*`; las rutas solo exigen `auth`. `php artisan test` = **14 passed / 50 assertions**. `view:cache` y `view:clear` OK.
- 2026-10-23 | agente | Restitución parcial de la verificación (D-015): `Auth::routes(['verify' => true])` vuelve a registrar `verification.notice|verify|resend`; sin `verified` en `students` ni en `clubs`. Nuevo `VerificationRoutesTest` para el estado | Corrección del usuario ("no queria que borraras las rutas...")
  - Verificado con `route:list` (36 rutas), `php artisan test` = **13 passed / 44 assertions** y el nuevo test de rutas.

## 8. Pendientes sugeridos

- Verificar en el repositorio qué piezas ya existen (migraciones, modelos, factories, seeders) y completar §2.
- Resolver las inconsistencias de §5.
- [OBSOLETO 2026-10-16, resuelto] `routes/web.php` referencia `App\Http\Controllers\AdminController` (rutas `/dashboard`, `/settings`), pero **la clase no existía** en `app/Http/Controllers`. Rompía `php artisan route:list` y fallaba al autenticarse y visitar esas URLs. **Resolución:** controlador creado + vistas `dashboard`/`settings` + nombres de ruta (ver §7, 2026-10-16).
- Crear/corregir los seis factories siguiendo AGENTS.md §7 y probarlos con `Modelo::factory()->make()`.
- [OBSOLETO 2026-10-22, resuelto] `auth/register`, `auth/verify` y `auth/passwords/confirm` extendían `layouts.app`; ahora usan `layouts.app_authentication` (D-012).
- [OBSOLETO 2026-10-22, resuelto] `welcome.blade.php` usaba Tailwind por CDN; ahora usa `layouts.app_authentication` y el partial `auth-ledger` (D-012).
- [OBSOLETO 2026-10-23, resuelto] `resources/views/auth/passwords/register.blade.php` era un duplicado no usado del registro, con logo inexistente y HTML mal cerrado; se eliminó tras confirmar que ninguna ruta ni vista lo referenciaba.
- [OBSOLETO 2026-10-23, resuelto] `auth/verify` no tenía rutas activas porque `User` no implementaba `MustVerifyEmail`; ahora la verificación está habilitada (D-013).
- [OBSOLETO 2026-10-23, resuelto] Exponer/manejar `clubs.status` y `clubs.registered_by`: `status` queda activo por defecto y `registered_by` se toma del usuario autenticado al crear el club (D-014).
- [PROPUESTA 2026-10-23] Los factories/seeders del dominio de facturación siguen pendientes; la implementación depende de resolver las inconsistencias de §5.
