# ขั้นตอนการทดสอบระบบ Slug-based Forms

## 1. Run Migration และ Seeder

```bash
# 1. Run migration เพื่อเพิ่ม slug column
php artisan migrate

# 2. Run seeder เพื่ออัพเดท slug ให้กับฟอร์มที่มีอยู่
php artisan db:seed --class=UpdateExistingFormsSlugSeeder
```

## 2. ทดสอบการสร้างฟอร์มใหม่

1. เข้าสู่ระบบ Admin
2. ไปที่หน้า **Form Management**
3. คลิก **Create New Form** หรือ **Generate URL**
4. กรอกข้อมูล:
   - **Slug**: `test-form-2025` (ใช้ตัวพิมพ์เล็ก, ตัวเลข, และ `-` เท่านั้น)
   - **Form Name**: `Test Form 2025`
5. คลิก **Save**
6. ระบบควรสร้างฟอร์มและ redirect ไปหน้าแก้ไขฟอร์ม

## 3. ทดสอบการเข้าถึงฟอร์ม

### ทดสอบ URL ใหม่
เปิดเบราว์เซอร์และทดสอบ URL:
```
http://localhost/metaknowledge-backoffice/form/test-form-2025
```

### ทดสอบฟอร์มที่มีอยู่แล้ว
หลังจาก run seeder แล้ว ทดสอบฟอร์มเดิม:
```
http://localhost/metaknowledge-backoffice/form/gmec
http://localhost/metaknowledge-backoffice/form/imocsea
http://localhost/metaknowledge-backoffice/form/isocsea
```

## 4. ทดสอบ Validation

### ทดสอบ Slug ที่ไม่ถูกต้อง
พยายามสร้างฟอร์มด้วย slug ที่ผิดรูปแบบ:
- ❌ `Test Form` (มีช่องว่าง)
- ❌ `TEST-FORM` (ตัวพิมพ์ใหญ่)
- ❌ `test_form` (ใช้ underscore)
- ✅ `test-form` (ถูกต้อง)

### ทดสอบ Slug ซ้ำ
พยายามสร้างฟอร์มด้วย slug ที่มีอยู่แล้ว:
- ระบบควรแสดง error: "Slug นี้ถูกใช้งานแล้ว กรุณาเลือก Slug อื่น"

## 5. ทดสอบ Opening/Closing Time Middleware

1. ตรวจสอบว่าตาราง `opening_closing_time` มีข้อมูลที่ตรงกับ slug
2. ทดสอบเข้าถึงฟอร์มที่:
   - ✅ เปิดรับสมัคร (status = 'Online' และอยู่ในช่วงเวลา)
   - ❌ ปิดรับสมัคร (status = 'Offline' หรือนอกช่วงเวลา)

## 6. ทดสอบการแก้ไขฟอร์ม

1. เข้าไปแก้ไขฟอร์มที่มีอยู่
2. ตรวจสอบว่า slug ยังคงเดิม (ไม่ควรเปลี่ยน)
3. บันทึกการแก้ไข
4. ทดสอบเข้าถึงฟอร์มด้วย URL เดิม

## 7. ทดสอบการลบฟอร์ม

1. ลบฟอร์มทดสอบที่สร้างไว้
2. ทดสอบเข้าถึง URL ของฟอร์มที่ถูกลบ
3. ควรได้ 404 Not Found

## 8. ทดสอบ Form Submission

1. เปิดฟอร์มด้วย URL ใหม่
2. กรอกข้อมูลและ submit
3. ตรวจสอบว่าข้อมูลถูกบันทึกในฐานข้อมูลถูกต้อง
4. ตรวจสอบว่า email confirmation ถูกส่งถูกต้อง

## 9. ตรวจสอบ Backward Compatibility

### ถ้ามี URL เก่าที่ยังใช้งานอยู่
ถ้าคุณต้องการให้ URL เก่ายังใช้งานได้ ให้เพิ่ม redirect routes:

```php
// ใน routes/web.php
Route::get('/gmec', function() {
    return redirect()->route('form.show', ['slug' => 'gmec']);
});

Route::get('/imocsea', function() {
    return redirect()->route('form.show', ['slug' => 'imocsea']);
});
// ... เพิ่มสำหรับ route อื่นๆ ที่ต้องการ
```

## 10. Performance Testing

1. สร้างฟอร์มหลายๆ ฟอร์ม (10-20 ฟอร์ม)
2. ทดสอบเวลาในการโหลดหน้า Form Management
3. ทดสอบเวลาในการเข้าถึงฟอร์มแต่ละฟอร์ม

## Checklist

- [ ] Migration สำเร็จ
- [ ] Seeder อัพเดท slug ให้ฟอร์มเดิมสำเร็จ
- [ ] สร้างฟอร์มใหม่ได้
- [ ] เข้าถึงฟอร์มด้วย URL ใหม่ได้
- [ ] Validation slug ทำงานถูกต้อง
- [ ] Slug ซ้ำถูก reject
- [ ] Opening/Closing time middleware ทำงานถูกต้อง
- [ ] แก้ไขฟอร์มได้
- [ ] ลบฟอร์มได้
- [ ] Submit ฟอร์มได้
- [ ] Email confirmation ส่งถูกต้อง

## หมายเหตุ

- ถ้าพบปัญหา ให้ตรวจสอบ log ที่ `storage/logs/laravel.log`
- ตรวจสอบ database ว่า slug ถูกบันทึกถูกต้อง
- ตรวจสอบ middleware `check.opening.date.time` ว่าทำงานกับ slug ได้
