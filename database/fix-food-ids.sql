-- =============================================
-- SỬA LẠI FOOD_ID - BỎ SỐ -2 Ở CUỐI
-- =============================================

USE travinh_tourism;

-- Cập nhật food_id trong bảng foods
UPDATE foods SET food_id = 'com-tam-suon-nuong' WHERE food_id = 'com-tam-suon-nuong-2';
UPDATE foods SET food_id = 'hu-tieu-my-tho' WHERE food_id = 'hu-tieu-my-tho-2';
UPDATE foods SET food_id = 'banh-mi-thit' WHERE food_id = 'banh-mi-thit-2';
UPDATE foods SET food_id = 'ca-phe-sua-da' WHERE food_id = 'ca-phe-sua-da-2';
UPDATE foods SET food_id = 'nuoc-mia' WHERE food_id = 'nuoc-mia-2';
UPDATE foods SET food_id = 'tra-sua' WHERE food_id = 'tra-sua-2';
UPDATE foods SET food_id = 'sinh-to-bo' WHERE food_id = 'sinh-to-bo-2';
UPDATE foods SET food_id = 'kem-dua' WHERE food_id = 'kem-dua-2';
UPDATE foods SET food_id = 'banh-flan' WHERE food_id = 'banh-flan-2';

-- Cập nhật food_type trong bảng restaurants
UPDATE restaurants SET food_type = 'com-tam-suon-nuong' WHERE food_type = 'com-tam-suon-nuong-2';
UPDATE restaurants SET food_type = 'hu-tieu-my-tho' WHERE food_type = 'hu-tieu-my-tho-2';
UPDATE restaurants SET food_type = 'banh-mi-thit' WHERE food_type = 'banh-mi-thit-2';
UPDATE restaurants SET food_type = 'ca-phe-sua-da' WHERE food_type = 'ca-phe-sua-da-2';
UPDATE restaurants SET food_type = 'nuoc-mia' WHERE food_type = 'nuoc-mia-2';
UPDATE restaurants SET food_type = 'tra-sua' WHERE food_type = 'tra-sua-2';
UPDATE restaurants SET food_type = 'sinh-to-bo' WHERE food_type = 'sinh-to-bo-2';
UPDATE restaurants SET food_type = 'kem-dua' WHERE food_type = 'kem-dua-2';
UPDATE restaurants SET food_type = 'banh-flan' WHERE food_type = 'banh-flan-2';

-- Kiểm tra kết quả
SELECT '✅ Đã sửa xong food_id và food_type!' as 'Kết quả';

-- Hiển thị danh sách món ăn đã sửa
SELECT food_id, name FROM foods WHERE food_id IN (
    'com-tam-suon-nuong',
    'hu-tieu-my-tho',
    'banh-mi-thit',
    'ca-phe-sua-da',
    'nuoc-mia',
    'tra-sua',
    'sinh-to-bo',
    'kem-dua',
    'banh-flan'
);

-- Đếm số quán cho mỗi món
SELECT 
    f.food_id,
    f.name,
    COUNT(r.id) as so_quan
FROM foods f
LEFT JOIN restaurants r ON f.food_id = r.food_type
WHERE f.food_id IN (
    'com-tam-suon-nuong',
    'hu-tieu-my-tho',
    'banh-mi-thit',
    'ca-phe-sua-da',
    'nuoc-mia',
    'tra-sua',
    'sinh-to-bo',
    'kem-dua',
    'banh-flan'
)
GROUP BY f.food_id, f.name;
