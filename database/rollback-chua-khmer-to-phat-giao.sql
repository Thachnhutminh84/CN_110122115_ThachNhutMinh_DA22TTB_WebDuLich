-- Phục hồi lại category của Chùa Hang và Thiền Viện Trúc Lâm Duyên Hải
-- Chuyển từ "Chùa Khmer" về lại "Chùa Phật giáo"

-- Phục hồi Chùa Hang
UPDATE attractions 
SET category = 'Chùa Phật giáo' 
WHERE name LIKE '%Chùa Hang%' OR attraction_id LIKE '%chuahang%';

-- Phục hồi Thiền Viện Trúc Lâm Duyên Hải  
UPDATE attractions 
SET category = 'Chùa Phật giáo'
WHERE name LIKE '%Thiền Viện Trúc Lâm%' OR name LIKE '%Trúc Lâm Duyên Hải%' OR attraction_id LIKE '%truclamduyen%';

-- Kiểm tra kết quả
SELECT attraction_id, name, category 
FROM attractions 
WHERE name LIKE '%Chùa Hang%' OR name LIKE '%Trúc Lâm%';
