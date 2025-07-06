# 🧪 Guía de Pruebas - SunObra

## 🚀 Cómo Probar el Sistema

### Opción 1: Usar el Sistema Simplificado (Recomendado)

1. **Renombrar archivos**:
   ```bash
   mv .htaccess .htaccess-backup
   mv .htaccess-simple .htaccess
   mv index.php index-backup.php
   mv index-simple.php index.php
   ```

2. **Iniciar servidor**:
   ```bash
   php -S localhost:8000
   ```

3. **Probar URLs**:
   - `http://localhost:8000/` → Página principal
   - `http://localhost:8000/login` → Formulario de login
   - `http://localhost:8000/register` → Formulario de registro

### Opción 2: Usar Archivos de Prueba Directos

1. **Probar diagnóstico**:
   ```bash
   php -S localhost:8000
   ```
   - Ve a: `http://localhost:8000/test-login.php`

2. **Probar login original del usuario**:
   - Ve a: `http://localhost:8000/login-original.php`
   - Ve a: `http://localhost:8000/test-login-original.php`

3. **Probar login simple**:
   - Ve a: `http://localhost:8000/login-simple.php`

### Opción 3: Usar Sistema Original

1. **Restaurar archivos originales**:
   ```bash
   mv .htaccess .htaccess-simple
   mv .htaccess-backup .htaccess
   mv index.php index-simple.php
   mv index-backup.php index.php
   ```

## 🔍 Diagnóstico de Problemas

### Si ves errores de PHP:
1. Verifica que PHP esté instalado: `php -v`
2. Verifica que las extensiones PDO estén habilitadas
3. Revisa los logs de error de PHP

### Si ves errores de base de datos:
1. Verifica que MySQL esté corriendo
2. Verifica las credenciales en `app/library/db.php`
3. Verifica que la base de datos `SunObra` exista

### Si ves errores de archivos no encontrados:
1. Verifica que todos los archivos estén en las rutas correctas
2. Verifica permisos de archivos
3. Verifica que el autoload esté funcionando

## 📁 Estructura de Archivos Esperada

```
sunobra/
├── app/
│   ├── controllers/
│   │   ├── BaseController.php
│   │   ├── AuthController.php
│   │   └── HomeController.php
│   ├── models/
│   │   ├── UserModel.php
│   │   ├── ObreroModel.php
│   │   └── ClienteModel.php
│   ├── views/
│   │   ├── auth/
│   │   │   └── login.php
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── home.php
│   └── library/
│       └── db.php
├── assets/
│   └── imgs/
├── index.php (o index-simple.php)
├── .htaccess
├── test-login.php
└── login-simple.php
```

## 🎯 Próximos Pasos

1. **Probar el sistema simplificado**
2. **Verificar que el login funcione**
3. **Crear usuarios de prueba en la base de datos**
4. **Probar el flujo completo de autenticación**

## 📞 Soporte

Si encuentras problemas:
1. Revisa los logs de error
2. Usa `test-login.php` para diagnóstico
3. Verifica la configuración de la base de datos
4. Asegúrate de que todos los archivos estén presentes 