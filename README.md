# 📋 RegisterForm - System Rejestracji Kandydatów

<div align="center">

![Symfony](https://img.shields.io/badge/Symfony-7.3-000000?style=for-the-badge&logo=symfony)
![Vue.js](https://img.shields.io/badge/Vue.js-3.5-4FC08D?style=for-the-badge&logo=vue.js)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![Doctrine](https://img.shields.io/badge/Doctrine-3.5-F56D00?style=for-the-badge&logo=doctrine)

*Nowoczesny system rejestracji kandydatów z eleganckim interfejsem użytkownika*

</div>

## 🚀 Opis Projektu

RegisterForm to pełnofunkcjonalny system rejestracji kandydatów składający się z:
- **Backend API** - Symfony 7.3 z Doctrine ORM
- **Frontend** - Vue.js 3 z Vite
- **Baza danych** - SQLite 

System umożliwia kandydatom rejestrację z kompletnymi danymi osobowymi, kontaktowymi oraz doświadczeniem zawodowym.

## ✨ Funkcjonalności

### 🎯 Główne cechy
- **Wieloetapowy formularz** - intuicyjny wizard rejestracji
- **Walidacja danych** - kompleksowa walidacja po stronie frontendu i backendu
- **RESTful API** - czyste endpointy do komunikacji
- **Architektura MVC** - czytelna struktura kodu

### 📊 Struktura danych
- **Dane podstawowe** - imię, nazwisko, data urodzenia
- **Dane kontaktowe** - email, telefon
- **Doświadczenie zawodowe** - historia zatrudnienia

## 🛠️ Technologie

### Backend
- **Symfony 7.3** - framework PHP
- **Doctrine ORM 3.5** - mapowanie obiektowo-relacyjne
- **PHP 8.2+** - nowoczesny PHP z typami
- **SQLite** - baza danych
- **Nelmio CORS** - obsługa CORS

### Frontend
- **Vue.js 3** - framework JavaScript
- **Vite** - narzędzie budowania
- **Axios** - komunikacja HTTP
- **CSS3** - nowoczesne style z animacjami

## 📁 Struktura Projektu

```
SymfonyRegisterProject/
├── backend/                 # Symfony API
│   ├── src/
│   │   ├── Controller/      # Kontrolery API
│   │   ├── Entity/          # Encje Doctrine
│   │   ├── Repository/      # Repozytoria danych
│   │   └── Service/         # Logika biznesowa
│   ├── config/              # Konfiguracja Symfony
│   ├── migrations/          # Migracje bazy danych
│   └── public/              # Punkt wejścia aplikacji
├── frontend/                # Vue.js aplikacja
│   ├── src/
│   │   ├── components/      # Komponenty Vue
│   │   └── assets/          # Zasoby statyczne
│   └── public/              # Pliki publiczne
└── README.md
```

## 🚀 Instalacja i Uruchomienie

### Wymagania
- PHP 8.2+
- Composer
- Node.js 18+
- npm/yarn

### Backend (Symfony)

```bash
# Przejdź do folderu backend
cd backend

# Zainstaluj zależności
composer install

# Skonfiguruj bazę danych w .env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

# Uruchom migracje
php bin/console doctrine:migrations:migrate

# Uruchom serwer deweloperski
symfony serve
# lub
php -S localhost:8000 -t public
```

### Frontend (Vue.js)

```bash
# Przejdź do folderu frontend
cd frontend

# Zainstaluj zależności
npm install

# Uruchom serwer deweloperski
npm run dev
```

## 🔧 Konfiguracja

### Backend (.env)
```env
APP_ENV=dev
APP_SECRET=your-secret-key
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
```

### Frontend (vite.config.js)
```javascript
export default defineConfig({
  plugins: [vue()],
  server: {
    port: 3000,
    proxy: {
      '/api': 'http://localhost:8000'
    }
  }
})
```

## 📡 API Endpoints

### Kandydaci
- `POST /api/candidates` - Utworzenie nowego kandydata

### Przykład żądania
```json
{
  "basicData": {
    "firstName": "Jan",
    "lastName": "Kowalski",
    "birthDate": "1990-01-01"
  },
  "contactData": {
    "phone": "+48123456789",
    "email": "jan.kowalski@example.com",
  },
  "experiences": [
    {
      "company": "Przykładowa Firma",
      "position": "Developer",
      "startDate": "2020-01-01",
      "endDate": "2023-12-31"
    }
  ]
}
```

## 🎨 Design System

### Kolory
- **Primary**: `#092998` - Niebieski główny
- **Background**: Gradient animowany
- **Text**: Biały na ciemnym tle

### Animacje
- **Gradient Shift** - płynne przejścia kolorów tła
- **Float** - subtelne animacje elementów
- **Transitions** - płynne przejścia między stanami


## 👨‍💻 Autor

**NoMercy404**
- GitHub: [@NoMercy404](https://github.com/NoMercy404)

