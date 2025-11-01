# 🚀 Quick Start Guide - Slug-based Forms

## ขั้นตอนเริ่มต้นอย่างรวดเร็ว

### 1️⃣ Run Migration (5 นาที)

```bash
# เข้าไปที่ directory ของโปรเจค
cd c:\xampp\htdocs\metaknowledge-backoffice

# Run migration
php artisan migrate

# ตอบ 'yes' เมื่อถูกถาม (ถ้าอยู่ใน production mode)
```

### 2️⃣ Update Existing Forms (2 นาที)

**วิธีที่ 1: ใช้ Seeder (แนะนำ)**
```bash
php artisan db:seed --class=UpdateExistingFormsSlugSeeder
```

**วิธีที่ 2: ใช้ SQL Script**
```bash
# เปิด phpMyAdmin หรือ MySQL client
# Import และ run ไฟล์: database/sql/update_forms_slug.sql
```

**วิธีที่ 3: ใช้ Tinker**
```bash
php artisan tinker

# ใน tinker พิมพ์:
$forms = \App\Models\FormManage::whereNull('slug')->get();
foreach ($forms as $form) { 
    $form->slug = str_replace('_', '-', strtolower($form->form_route)); 
    $form->save(); 
}
exit
```

### 3️⃣ Clear Cache (1 นาที)

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
```

### 4️⃣ ทดสอบ (5 นาที)

#### ทดสอบฟอร์มเดิม
เปิดเบราว์เซอร์และทดสอบ URL:
```
http://localhost/metaknowledge-backoffice/form/gmec
http://localhost/metaknowledge-backoffice/form/imocsea
```

#### สร้างฟอร์มใหม่
1. Login เข้าระบบ admin
2. ไปที่ Form Management
3. คลิก "Create New Form"
4. กรอก:
   - Slug: `test-form-2025`
   - Form Name: `Test Form 2025`
5. Save

#### ทดสอบฟอร์มที่สร้างใหม่
```
http://localhost/metaknowledge-backoffice/form/test-form-2025
```

---

## ✅ Checklist

- [ ] Migration สำเร็จ (ตรวจสอบว่ามี column `slug` ในตาราง `forms_manage`)
- [ ] Slug ถูกอัพเดทให้ฟอร์มเดิมแล้ว
- [ ] Cache ถูก clear แล้ว
- [ ] ทดสอบเข้าฟอร์มเดิมได้
- [ ] สร้างฟอร์มใหม่ได้
- [ ] ทดสอบเข้าฟอร์มใหม่ได้

---

## 🎯 การใช้งานหลังจากนี้

### สร้างฟอร์มใหม่

1. ไปที่ Form Management
2. คลิก "Create New Form"
3. กรอก Slug (เช่น `my-new-form-2025`)
   - ใช้ตัวพิมพ์เล็ก
   - ใช้ `-` แทนช่องว่าง
   - ไม่ใช้ underscore หรืออักขระพิเศษ
4. กรอกชื่อฟอร์ม
5. Save

### เข้าถึงฟอร์ม

URL รูปแบบใหม่:
```
https://yourdomain.com/form/{slug}
```

ตัวอย่าง:
```
https://yourdomain.com/form/imocsea-2025
https://yourdomain.com/form/mathleague-final
```

---

## 🆘 แก้ปัญหาเร่งด่วน

### ปัญหา: Migration ไม่ทำงาน
```bash
# ตรวจสอบ database connection
php artisan migrate:status

# ถ้ายังไม่ได้ run migration
php artisan migrate --force
```

### ปัญหา: 404 Not Found
1. ตรวจสอบว่า slug มีในฐานข้อมูล:
```sql
SELECT id, form_name, slug FROM forms_manage;
```

2. Clear route cache:
```bash
php artisan route:clear
```

### ปัญหา: Route times not set
1. ตรวจสอบตาราง `opening_closing_time`:
```sql
SELECT * FROM opening_closing_time WHERE route = 'your-slug';
```

2. เพิ่ม record ถ้าไม่มี:
```sql
INSERT INTO opening_closing_time (route, opening_time, closing_time, status, created_at, updated_at)
VALUES ('your-slug', '2025-01-01 00:00:00', '2025-12-31 23:59:59', 'Online', NOW(), NOW());
```

### ปัญหา: Slug validation error
ตรวจสอบว่า slug:
- ✅ ใช้ตัวพิมพ์เล็กเท่านั้น
- ✅ ใช้ `-` แทนช่องว่าง
- ✅ ไม่มี underscore (_)
- ✅ ไม่ซ้ำกับ slug อื่น

---

## 📞 ติดต่อ

ถ้ามีปัญหาหรือข้อสงสัย:
1. ตรวจสอบ log: `storage/logs/laravel.log`
2. อ่านเอกสารเพิ่มเติม: `SLUG_MIGRATION_SUMMARY.md`
3. ดูขั้นตอนทดสอบ: `TESTING_STEPS.md`

---

## 🎉 เสร็จแล้ว!

ตอนนี้คุณสามารถสร้างฟอร์มใหม่ได้โดยไม่ต้องแก้ไขโค้ดอีกต่อไป! 🚀
