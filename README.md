
# ATM İdarəetməsi API

Bu layihə **ATM idarəetməsi** üçün API təqdim edir. API istifadəçiləri **ATM**-dən pul nağdlaşdırmaq, hesablar yaratmaq, əməliyyat tarixçəsini əldə etmək və xüsusi istifadəçilərin əməliyyatları silməsini təmin edir. Məqsəd **minimum əskinazlarla** pul nağdlaşdırılmasını təmin etməkdir.

## Layihə Tələbləri

- **PHP**: ^8
- **Laravel**: ^8
- **MySQL**: 5.7 və ya daha yüksək versiya

## Quraşdırma

Bu layihəni local serverdə qurmaq üçün aşağıdakı addımları izləyin:

### 1. Git Repository-ni Klonlayın

```bash
git clone https://github.com/RamilHuseynov/ATM.git
cd ATM
```

### 2. Composer-i Yükləyin

Composer-i istifadə edərək asılılıqları yükləyin:

```bash
composer install
```

### 3. `.env` Faylını Konfiqurasiya Edin

`.env.example` faylını `.env` olaraq kopyalayın və verilənlər bazası və digər konfiqurasiya parametrlərini uyğunlaşdırın.

```bash
cp .env.example .env
```

### 4. Verilənlər Bazası

Verilənlər bazasını qurmaq və miqrasiyaları icra etmək üçün aşağıdakı əmri icra edin:

```bash
php artisan migrate
```

### 5. Əlavə Konfiqurasiyalar

Əgər **middleware** və **routes** ilə bağlı xüsusi dəyişikliklər etmisinizsə, uyğun konfiqurasiyaları `.env` və `config/auth.php` faylında təkrarlayın.

### 6. Serveri Başladın

Layihəni başlatmaq üçün aşağıdakı əmri icra edin:

```bash
php artisan serve
```

Server artıq `http://localhost:8000` ünvanında işləməyə başlayacaq.

## API İstifadəsi

API-nin əsas endpointləri aşağıda göstərilmişdir.

### 1. **Hesab Yaratma**

- **Endpoint**: `POST /api/accounts`
- **Body**:
  ```json
  {
    "balance": 1000
  }
  ```
- **Response**:
  ```json
  {
    "id": 1,
    "balance": 1000,
    "created_at": "2025-02-12T12:00:00",
    "updated_at": "2025-02-12T12:00:00"
  }
  ```

### 2. **Pul Çıxarışı**

- **Endpoint**: `POST /api/accounts/{account}/withdraw`
- **Body**:
  ```json
  {
    "amount": 125
  }
  ```
- **Response**:
  ```json
  {
      "message": "Withdrawal successful",
        "transaction": {
        "account_id": 3,
        "amount": 125,
        "type": "withdraw",
        "updated_at": "2025-02-12T14:35:27.000000Z",
        "created_at": "2025-02-12T14:35:27.000000Z",
        "id": 5
    },
    "bills": {
        "100": 1,
        "20": 1,
        "5": 1
  }
  ```

### 3. **Əməliyyat Tarixçəsi**

- **Endpoint**: `GET /api/accounts/{account}/history`
- **Response**:
  ```json
  [
    {
      "id": 1,
      "account_id": 1,
      "amount": 125,
      "operation_type": "withdrawal",
      "created_at": "2025-02-12T12:00:00"
    }
  ]
  ```

### 4. **Əməliyyat Silinməsi (Xüsusi İstifadəçilər üçün)**

- **Endpoint**: `DELETE /api/transactions/{transaction}`
- **Headers**:
  ```bash
  Authorization: Bearer <token>
  ```
- **Response**:
  ```json
  {
    "message": "Əməliyyat uğurla silindi"
  }
  ```

### 5. **Admin Əməliyyatı Silmək Üçün**

Adminlər üçün əməliyyatları silmək icazəsi verilmişdir. Əgər admin deyilsinizsə, 403 Unauthorized xətası alacaqsınız.

## Digər Xüsusiyyətlər

- **Əskinazlar**: ATM-da mövcud olan əskinazlar: 200, 100, 50, 20, 10, 5, 1 AZN.
- **Minimum əskinaz**: Pul çıxarışı zamanı istifadəçilərə minimum sayda əskinaz verilir.

## Yekun

Bu API layihəsi **ATM idarəetməsi** üçün əsas funksiyaları təmin edir, o cümlədən **hesab yaratmaq**, **pul çıxarmaq**, **əskinasları optimallaşdırmaq** və **admin əməliyyatları** silmək. Hər bir endpoint-in istifadə qaydaları **Postman** və ya digər **API test** vasitələri ilə yoxlanıla bilər.
