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

## 2. Contexto del proyecto

- Fuente: documento *Unidad Temática II – Base de Datos (Database)*, Framework Laravel.
- Dominio ejemplo: tienda/sistema de ventas con `Producto`, `Cliente`, `Factura`, `Detallefactura`, `MetodoPago`, `Pago`.
- Base de datos de referencia: MySQL, configurada vía `.env` (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- Estado de implementación real (qué migraciones, modelos, factories y seeders existen ya): **no verificado**. Revisa el repositorio y actualiza esta sección.

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

## 8. Pendientes sugeridos

- Verificar en el repositorio qué piezas ya existen (migraciones, modelos, factories, seeders) y completar §2.
- Resolver las inconsistencias de §5.
- Crear/corregir los seis factories siguiendo AGENTS.md §7 y probarlos con `Modelo::factory()->make()`.
