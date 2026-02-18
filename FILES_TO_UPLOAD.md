# لیست فایل‌های مورد نیاز برای آپلود در هاست 📤

## ⚠️ مهم: قبل از آپلود
1. از تمام فایل‌های موجود در هاست بکاپ بگیرید
2. در ساعات کم‌ترافیک آپلود کنید
3. بعد از آپلود، حتماً تست کنید

---

## 📁 فایل‌های مایگریشن (ضروری)

این فایل‌ها باید در پوشه `database/migrations/` آپلود شوند:

```
core/database/migrations/2026_02_17_205806_create_games_table.php
core/database/migrations/2026_02_17_211834_add_game_id_to_schedule_items_table.php
```

**نکته:** مایگریشن‌ها قبلاً در دیتابیس اجرا شده‌اند، اما باید فایل‌ها را آپلود کنید تا در آینده مشکلی پیش نیاید.

---

## 📁 فایل‌های Model (ضروری)

### 1. Model جدید Game
```
core/app/Models/Game.php
```

### 2. Model ScheduleItem (تغییر کرده)
```
core/app/Models/Market/ScheduleItem.php
```
**تغییرات:** فیلد `game_id` به fillable اضافه شده و relationship `game()` اضافه شده

---

## 📁 فایل‌های Controller (ضروری)

### 1. ScheduleController (تغییر کرده)
```
core/app/Http/Controllers/Admin/ScheduleController.php
```
**تغییرات:** 
- در متد `edit()`: relationship با game اضافه شده
- در متد `store()` و `update()`: پشتیبانی از `game_id` اضافه شده

### 2. GameController (جدید یا تغییر کرده)
```
core/app/Http/Controllers/Admin/GameController.php
```
**نکته:** اگر این فایل در هاست وجود ندارد، باید آپلود شود

---

## 📁 فایل‌های View (ضروری)

### 1. صفحه ویرایش برنامه (تغییر کرده)
```
core/resources/views/admin/schedule/edit.blade.php
```
**تغییرات:** 
- مشکل `gameSelect` حل شده
- متغیر `gameSelect` در JavaScript اضافه شده

### 2. صفحه ایجاد برنامه (بررسی کنید)
```
core/resources/views/admin/schedule/create.blade.php
```
**نکته:** اگر این فایل هم تغییر کرده، باید آپلود شود

---

## 📁 فایل Routes (ضروری)

### web.php (اگر route جدید اضافه شده)
```
core/routes/web.php
```
**تغییرات:** Route جدید برای `get-games-by-sub-season` اضافه شده

**بررسی کنید:** خط زیر باید در فایل وجود داشته باشد:
```php
Route::get('/get-games-by-sub-season', [GameController::class, 'getGamesBySubSeason'])->name('admin.game.get-games-by-sub-season');
```

---

## 📋 چک‌لیست آپلود

### مرحله 1: بکاپ
- [ ] بکاپ از تمام فایل‌های موجود در هاست
- [ ] بکاپ از دیتابیس (قبلاً انجام شده)

### مرحله 2: آپلود فایل‌های Model
- [ ] `core/app/Models/Game.php` → `app/Models/Game.php`
- [ ] `core/app/Models/Market/ScheduleItem.php` → `app/Models/Market/ScheduleItem.php`

### مرحله 3: آپلود فایل‌های Controller
- [ ] `core/app/Http/Controllers/Admin/ScheduleController.php` → `app/Http/Controllers/Admin/ScheduleController.php`
- [ ] `core/app/Http/Controllers/Admin/GameController.php` → `app/Http/Controllers/Admin/GameController.php`

### مرحله 4: آپلود فایل‌های View
- [ ] `core/resources/views/admin/schedule/edit.blade.php` → `resources/views/admin/schedule/edit.blade.php`
- [ ] `core/resources/views/admin/schedule/create.blade.php` → `resources/views/admin/schedule/create.blade.php` (اگر تغییر کرده)

### مرحله 5: آپلود فایل Routes
- [ ] `core/routes/web.php` → `routes/web.php` (فقط اگر route جدید اضافه شده)

### مرحله 6: آپلود فایل‌های مایگریشن
- [ ] `core/database/migrations/2026_02_17_205806_create_games_table.php` → `database/migrations/2026_02_17_205806_create_games_table.php`
- [ ] `core/database/migrations/2026_02_17_211834_add_game_id_to_schedule_items_table.php` → `database/migrations/2026_02_17_211834_add_game_id_to_schedule_items_table.php`

---

## 🔍 بررسی بعد از آپلود

### 1. بررسی فایل‌ها
- [ ] مطمئن شوید همه فایل‌ها درست آپلود شده‌اند
- [ ] بررسی کنید که مسیر فایل‌ها درست است

### 2. تست عملکرد
- [ ] وارد صفحه ایجاد برنامه شوید → باید کار کند
- [ ] وارد صفحه ویرایش برنامه شوید → باید کار کند
- [ ] تغییر فصل اصلی در صفحه ویرایش → باید زیر فصل‌ها لود شوند
- [ ] انتخاب بازی در برنامه → باید کار کند

### 3. بررسی لاگ‌ها
- [ ] بررسی کنید خطایی در `storage/logs/laravel.log` وجود ندارد

---

## ⚠️ نکات مهم

1. **مسیر فایل‌ها:** 
   - در پروژه شما فایل‌ها در پوشه `core/` هستند
   - در هاست باید بدون `core/` آپلود شوند
   - مثال: `core/app/Models/Game.php` → `app/Models/Game.php`

2. **دسترسی فایل‌ها:**
   - مطمئن شوید دسترسی فایل‌ها درست است (644 برای فایل‌ها، 755 برای پوشه‌ها)

3. **Cache:**
   - بعد از آپلود، cache را پاک کنید:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

4. **اگر خطا گرفتید:**
   - فایل‌های بکاپ را بازگردانید
   - لاگ‌ها را بررسی کنید
   - با تیم فنی تماس بگیرید

---

## 📝 خلاصه فایل‌های ضروری

**فایل‌های حتماً باید آپلود شوند:**
1. ✅ `app/Models/Game.php` (جدید)
2. ✅ `app/Models/Market/ScheduleItem.php` (تغییر کرده)
3. ✅ `app/Http/Controllers/Admin/ScheduleController.php` (تغییر کرده)
4. ✅ `app/Http/Controllers/Admin/GameController.php` (بررسی کنید)
5. ✅ `resources/views/admin/schedule/edit.blade.php` (تغییر کرده)
6. ✅ `routes/web.php` (اگر route جدید اضافه شده)
7. ✅ `database/migrations/2026_02_17_205806_create_games_table.php`
8. ✅ `database/migrations/2026_02_17_211834_add_game_id_to_schedule_items_table.php`

**فایل‌های اختیاری (بررسی کنید):**
- `resources/views/admin/schedule/create.blade.php` (اگر تغییر کرده)

---

## 🚀 دستورات مفید بعد از آپلود

اگر دسترسی SSH/Terminal دارید:

```bash
# پاک کردن cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# بررسی وضعیت مایگریشن‌ها
php artisan migrate:status

# بررسی route‌ها
php artisan route:list | grep game
```

---

## ✅ نتیجه

بعد از آپلود همه فایل‌ها و پاک کردن cache، باید:
- صفحه ایجاد برنامه کار کند
- صفحه ویرایش برنامه کار کند
- تغییر فصل اصلی در ویرایش، زیر فصل‌ها را لود کند
- انتخاب بازی در برنامه کار کند

