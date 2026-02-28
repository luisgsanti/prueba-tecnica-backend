# 🧩 Sistema de Registro y Administración – Prueba Técnica

Sistema web fullstack desarrollado como prueba técnica, que permite el registro dinámico de usuarios (persona natural y jurídica) y la administración completa de los registros mediante un panel protegido con autenticación JWT.

El sistema está compuesto por:

- 🌐 Aplicación pública de registro dinámico  
- 🔐 Panel administrativo protegido  
- 📡 API REST desarrollada en Laravel  
- 🎨 SPA desarrollada en Angular 18  

---

# 🏗 Arquitectura del Proyecto

El sistema está dividido en dos aplicaciones independientes:

Backend  → Laravel 12 (API REST + JWT)  
Frontend → Angular 18 (SPA + Tailwind CSS)

Se implementó separación clara entre:

- Módulo público
- Módulo administrativo
- Layouts independientes
- Componentes reutilizables
- Guards e interceptores

---

# ⚙️ Backend

## 🧰 Tecnologías

- PHP 8.2.12
- Laravel 12.x
- MySQL 8+
- JWT (tymon/jwt-auth)
- Arquitectura REST API
- CORS configurado manualmente

## 🔐 Autenticación

- Autenticación basada en JWT
- Guard personalizado para administradores
- Middleware protegido (`auth:admin`)
- Manejo de excepciones personalizado
- Protección de rutas administrativas

## 🗂 Base de Datos

Modelo relacional compuesto por:

- `users`
- `user_types`
- `questions`
- `answers`
- `admin_users`

### Relaciones implementadas:

- User → belongsTo UserType  
- User → hasMany Answers  
- Answer → belongsTo Question  

## 📡 Endpoints principales

### Público

- `GET /user-types`
- `GET /questions/{userTypeId}`
- `POST /register`

### Administración

- `POST /admin/login`
- `GET /admin/users`
- `PATCH /admin/users/{id}/toggle-status`
- `PATCH /admin/user-types/{id}/toggle`

---

# 🎨 Frontend

## 🧰 Tecnologías

- Angular 18 (Standalone Components)
- TypeScript
- Tailwind CSS
- Reactive Forms
- Angular Router
- HTTP Interceptor
- Functional Guards

## 🧭 Arquitectura Frontend

### Layouts

- PublicLayout (sitio público)
- AdminLayout (panel administrativo con sidebar responsive)

### Componentes principales

- Home (selección tipo de usuario)
- Register (formulario dinámico)
- AdminLogin
- AdminDashboard (gestión de usuarios)
- AdminUserTypes
- UserDetailModal (modal independiente para visualizar datos completos)

## 🔐 Seguridad

- Interceptor JWT automático
- AuthGuard para proteger rutas administrativas
- Logout con limpieza de token
- Protección en frontend y backend

---

# 🧩 Funcionalidades Implementadas

## 🌐 Módulo Público

- Selección dinámica de tipo de usuario
- Formulario reactivo dinámico
- Validaciones frontend y backend
- Validación condicional para persona jurídica
- Registro persistente en base de datos

## 🔐 Panel Administrativo

- Login protegido con JWT
- Sidebar responsive
- Gestión de usuarios
- Deshabilitar / habilitar usuarios
- Gestión de tipos de usuario
- Deshabilitar / habilitar tipos
- Visualización completa de los datos registrados
- Modal independiente para detalle del usuario
- Diseño responsive tipo SaaS

---

# 📱 Responsive Design

- Sidebar colapsable en móvil
- Tablas con scroll horizontal controlado
- Layout adaptable
- Diseño moderno y profesional

---

# 🛠 Versiones Utilizadas

### Backend

- PHP 8.2.12
- Laravel 12.x
- MySQL 8+

### Frontend

- Angular 18.x
- Node 18+
- Tailwind CSS 3+

---

# 🚀 Cómo ejecutar el proyecto

## Backend

```bash
composer install
php artisan migrate
php artisan serve
