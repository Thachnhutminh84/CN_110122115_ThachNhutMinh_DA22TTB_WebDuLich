-- Cập nhật category của Chùa Hang và Thiền Viện Trúc Lâm Duyên Hải
-- Chuyển từ "Chùa Phật giáo" sang "Chùa Khmer"

-- Cập nhật Chùa Hang
UPDATE attractions 
SET category = 'Chùa Khmer' 
WHERE name LIKE '%Chùa Hang%' OR attraction_id LIKE '%chuahang%';

-- Cập nhật Thiền Viện Trúc Lâm Duyên Hải  
UPDATE attractions 
SET category = 'Chùa Khmer'
WHERE name LIKE '%Thiền Viện Trúc Lâm%' OR name LIKE '%Trúc Lâm Duyên Hải%' OR attraction_id LIKE '%truclamduyen%';

-- Kiểm tra kết quả
SELECT attraction_id, name, category 
FROM attractions 
WHERE name LIKE '%Chùa Hang%' OR name LIKE '%Trúc Lâm%';
