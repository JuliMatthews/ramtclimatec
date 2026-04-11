# Update V.11.04 - Panel Admin con Bootstrap

## Fecha: 11 de Abril de 2026

## Descripción
Migración completa del panel de administración desde Filament a vistas Blade customizadas con template Bootstrap, manteniendo el backend existente de Laravel.

---

## Cambios Realizados

### 1. Estructura del Proyecto
- **Template Bootstrap**: Agregado template admin en `public/admin/`
- **Favicon personalizado**: Cambiado de "B" azul a logo de RAMT Climatec
- **Logo actualizado**: Cambiado de "Corona" a "RAMT Climatec"

### 2. Módulos del Panel

#### Clientes (`/admin/clientes`)
- Vista de tabla con columnas: Tipo, Cliente, Región, Comuna, Correo, Teléfono, Equipos, Activo, Creado
- Acciones: Editar (lápiz), Eliminar
- Sin desplegable de equipos (se eliminó para mejor rendimiento)

#### Equipos (`/admin/equipos`)
- Vista principal muestra clientes con equipos (no equipos individuales)
- Columnas: Cliente, Tipo, Comuna, Correo, Teléfono, Equipos
- Botón "Ver Equipos" que lleva a página dedicada
- **Nueva página**: Lista completa de equipos por cliente
- **Exportación**: PDF y Excel con todos los datos del equipo
- **Tipo de equipo**: Menú desplegable (Split muro, Cassette, Ducto, etc.)
- **Fabricante (Marca)**: Menú desplegable con 76+ marcas

#### Errores (`/admin/errores`)
- Base de datos de errores de aires acondicionado importada desde Excel
- 176 errores cargados con campos: Código, Marca, Error, Causa, Solución
- Buscador por cualquier campo

#### Próximas Mantenciones (`/admin/mantenciones`)
- Nueva sección en menú lateral
- Tabla con: Equipo, Ubicación, Cliente, Próxima Mantención, Días restantes, Estado
- Estados: Vencido (rojo), Próximo (amarillo), Programado (verde)

#### Dashboard
- **Stats principales**: Clientes, Órdenes de Trabajo, Equipos, Materiales, Técnicos
- **Widgets nuevos**:
  - Mantenciones Vencidas (alerta roja)
  - Próximas Mantenciones (próximos 30 días)
  - Equipos por Marca (gráfico de barras)
  - Órdenes de Trabajo Recientes

### 3. Funcionalidades

#### Paginación
- Vista customizada `pagination/bootstrap-custom.blade.php`
- Estilos compactos y consistentes con el template
- Cursor pointer en hover

#### Carga de Direcciones por Cliente (AJAX)
- Al seleccionar cliente en crear/editar equipo, se cargan sus direcciones automáticamente
- Ruta: `/admin/direcciones/cliente/{id}`

#### Calculadora de Próxima Mantención
- Al seleccionar fecha de "Última Mantención", se calcula automáticamente la "Próxima Mantención" (+6 meses)
- JavaScript en el frontend

### 4. Base de Datos

#### Nuevas Migraciones
- `2026_04_11_011920_add_telefono_to_direcciones_table.php`: Agrega columna telefono a direcciones
- `2026_04_11_044004_create_error_aires_table.php`: Nueva tabla para errores de aires acondicionados

#### Modelos
- `ErrorAire`: Nuevo modelo para almacenar errores
- `Direccion`: Agregado accessor `getDireccionCompletaAttribute()`

### 5. Controladores

#### Nuevos Controladores
- `MantencionController`: Para la sección de Próximas Mantenciones
- `ImportErroresAires`: Comando Artisan para importar errores desde Excel

#### Controladores Actualizados
- `EquipoController`: 
  - `index()`: Ahora devuelve clientes con equipos
  - `porCliente()`: Nueva página de equipos por cliente
  - `exportarPdf()`: Exportar a PDF
  - `exportarExcel()`: Exportar a Excel
- `ClienteController`: Carga relaciones direcciones y equipos
- `ErrorController`: Ahora usa modelo ErrorAire con búsqueda
- `DashboardController`: Stats de mantenciones y equipos por marca

### 6. Vistas Blade

#### Estructura
- `layout.blade.php`: Layout principal con estilos de paginación
- `partials/sidebar.blade.php`: Menú lateral con iconos
- `partials/navbar.blade.php`: Barra superior con perfil

#### Vistas de Equipos
- `index.blade.php`: Lista de clientes con equipos
- `create.blade.php`: Formulario de creación completo
- `edit.blade.php`: Formulario de edición completo
- `show.blade.php`: Ver detalles completos del equipo
- `por-cliente.blade.php`: Lista de equipos por cliente
- `pdf.blade.php`: Plantilla para PDF

### 7. Exportación

#### Excel
- `EquiposExport`: Exporta todos los campos del equipo a Excel

#### PDF
- Exportación horizontal (landscape) para más columnas

---

## Archivos Agregados/Modificados

### Nuevos Archivos
- `app/Console/Commands/ImportErroresAires.php`
- `app/Exports/EquiposExport.php`
- `app/Http/Controllers/Admin/MantencionController.php`
- `app/Models/ErrorAire.php`
- `resources/views/admin/mantenciones/index.blade.php`
- `resources/views/admin/equipos/por-cliente.blade.php`
- `resources/views/admin/equipos/pdf.blade.php`
- `resources/views/pagination/bootstrap-custom.blade.php`

### Migraciones
- `database/migrations/2026_04_11_011920_add_telefono_to_direcciones_table.php`
- `database/migrations/2026_04_11_044004_create_error_aires_table.php`

---

## Notas para Deploy

### Requisitos
- PHP >= 8.4 (para composer)
- Base de datos MySQL
- Extensiones: pdo, mbstring, xml, zip, curl

### Pasos de Instalación
1. `composer install --ignore-platform-reqs --no-dev --optimize-autoloader`
2. `php artisan migrate --force`
3. `php artisan config:clear`
4. `php artisan cache:clear`
5. `php artisan view:clear`

---

## Actualización desde GitHub
```bash
git pull origin main
composer install --ignore-platform-reqs --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## Estado del Proyecto
- ✅ Frontend Bootstrap funcionando
- ✅ Backend Laravel intacto
- ✅ Base de datos migrada
- ✅ Errores importados
- ✅ Deploy en producción

---

*Generado: 11 de Abril de 2026*