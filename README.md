# 🏢 Portal de Vacantes IT Cuautla

Sistema web para gestión de **Servicio Social** y **Residencias Profesionales** del Instituto Tecnológico de Cuautla (TecNM).

⚡ **PROYECTO LISTO PARA USAR EN CUALQUIER MÁQUINA - MISMOS DATOS Y CONFIGURACIÓN**

---

## 🚀 USO SÚPER FÁCIL

### 🟢 **YA TIENES EL PROYECTO?** (Primera vez en nueva máquina)
```
1. Doble clic en: PRIMERA_VEZ.cmd
2. Espera que termine (instala dependencias)
3. ¡Listo!
```

### 🟢 **INICIAR EL PORTAL** (Uso diario)
```
Doble clic en: INICIAR.cmd
```
> Abre automáticamente: http://localhost:8080/vacantes

### 🔴 **DETENER SERVIDOR**
```
Presiona: Ctrl + C (en la ventana negra del servidor)
```

---

## 🛠️ NUEVA MÁQUINA - INSTALACIÓN DE PREREQUISITOS

### **PASO 1: Instalar PHP (XAMPP)**
1. **Descarga**: https://www.apachefriends.org/download.html
2. **Instala XAMPP** (solo necesitas PHP, pero instala todo)
3. **Agregar PHP al PATH de Windows**:
   - **Windows + R** → escribe `sysdm.cpl` → Enter
   - **Opciones avanzadas** → **Variables de entorno**
   - En **Variables del sistema** → busca **Path** → **Editar**
   - **Nuevo** → agrega: `C:\xampp\php`
   - **Aceptar todo** y **REINICIA Windows**

### **PASO 2: Instalar Composer**
1. **Descarga**: https://getcomposer.org/download/
2. **Ejecuta** `Composer-Setup.exe`
3. **Siguiente, siguiente, instalar** (detecta PHP automáticamente)
4. **REINICIA Windows**

### **PASO 3: Clonar proyecto**
```cmd
git clone https://github.com/tu-usuario/portal-vacantes-itc.git
cd portal-vacantes-itc
```

### **PASO 4: Primera ejecución**
```
Doble clic en: PRIMERA_VEZ.cmd
```

**¡YA ESTÁ! Tendrás exactamente los mismos datos y configuración.**

---

## 🌐 URLs del Portal

- **Portal Público**: http://localhost:8080/vacantes
- **Panel Admin**: http://localhost:8080/vacantes/admin
- **Crear Vacante**: http://localhost:8080/vacantes/crear

## 🔑 Credenciales Admin

- **Usuario**: `admin@cuautla.tecnm.mx`
- **Contraseña**: `admin123`

---

## 🎯 Características del Portal

✅ **Portal público** para estudiantes (sin registro)  
✅ **Panel empresas** para publicar vacantes  
✅ **Administración completa** con autenticación  
✅ **Filtros** por carrera y tipo de vacante  
✅ **Base de datos SQLite** portable (mismos datos en todas las máquinas)
✅ **Sistema de postulaciones** sin fricción
✅ **Dashboard** con estadísticas en tiempo real
✅ **Responsive design** con identidad institucional

---

## ⚠️ IMPORTANTES

### **Usar CMD, NO PowerShell**
- PowerShell NO reconoce composer correctamente
- Para abrir CMD: `Win + R` > escribe `cmd` > Enter

### **Sincronización entre máquinas**
- La base de datos SQLite se sincroniza automáticamente
- Los mismos datos en todas las máquinas
- No cambies credenciales ni configuración

### **Si algo no funciona**
1. Verifica que PHP esté en PATH: `php -v`
2. Verifica que Composer esté instalado: `composer -v`
3. Ejecuta `PRIMERA_VEZ.cmd` otra vez

---

## 📞 Contacto

Instituto Tecnológico de Cuautla (TecNM)  
Email: contacto@cuautla.tecnm.mx  
Web: https://cuautla.tecnm.mx
✅ **Diseño responsive** Bootstrap 5  
✅ **Colores institucionales** TecNM  
✅ **Sistema de postulaciones** sin fricción  
✅ **Dashboard** con estadísticas en tiempo real  
✅ **Seguridad CSRF** implementada  

---

## 🔧 Comandos Útiles (CMD)

```cmd
# Instalar dependencias
composer install

# Generar clave de aplicación
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Iniciar servidor
php artisan serve --port=8080

# Limpiar cache
php artisan config:clear
php artisan cache:clear
```

---

## 📂 Estructura del Proyecto

```
proyecto/
├── INICIAR.cmd          # Iniciar servidor
├── PRIMERA_VEZ.cmd      # Configuración inicial
├── PORTAL_FUNCIONAL.html # Versión sin PHP
├── app/                 # Código Laravel
├── database/            # Base de datos SQLite
├── public/              # Archivos públicos
├── resources/           # Vistas y assets
└── routes/              # Rutas web
```

---

## 🆘 Solución de Problemas

### **Error: "php no se reconoce"**
- ✅ Verifica que PHP esté en el PATH
- ✅ Reinicia Windows después de agregar al PATH
- ✅ Usa CMD, no PowerShell

### **Error: "composer no se reconoce"**
- ✅ Instala Composer desde getcomposer.org
- ✅ Reinicia Windows
- ✅ Usa CMD, no PowerShell

### **Error: Base de datos SQLite**
- ✅ Ejecuta `php artisan migrate --force`
- ✅ Verifica que existe `database/database.sqlite`

### **Puerto ocupado**
- ✅ Cambia el puerto en `INICIAR.cmd`:
  ```cmd
  php artisan serve --port=8081
  ```

---

**🎓 Desarrollado para el Instituto Tecnológico de Cuautla (TecNM) 🎓**
