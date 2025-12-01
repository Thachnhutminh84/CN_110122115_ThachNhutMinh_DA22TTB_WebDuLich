// ===== HỆ THỐNG TÌM QUÁN ĂN =====

class RestaurantFinder {
    constructor() {
        this.restaurants = [];
        this.currentFood = null;
        this.init();
    }

    init() {
        console.log('🍽️ Restaurant Finder initialized');
        this.loadRestaurantData();
    }

    // Dữ liệu quán ăn đầy đủ
    loadRestaurantData() {
        this.restaurants = {
            'bun-nuoc-leo': [
                {
                    id: 'bun-nuoc-leo-1',
                    name: 'Quán Bún Nước Lèo Cô Ba',
                    address: 'Chợ Trà Vinh, Phường 1, TP. Trà Vinh',
                    phone: '0294.3855.123',
                    rating: 4.8,
                    price: '25.000 - 35.000 VNĐ',
                    openTime: '6:00 - 22:00',
                    specialties: ['Bún nước lèo', 'Bún riêu cua', 'Bánh canh cua'],
                    image: 'images/quan-bun-nuoc-leo-co-ba.jpg',
                    coordinates: { lat: 9.9345, lng: 106.3421 },
                    description: 'Quán bún nước lèo lâu đời nhất thành phố với hương vị đậm đà truyền thống.'
                },
                {
                    id: 'bun-nuoc-leo-2',
                    name: 'Bún Nước Lèo Chú Tám',
                    address: '123 Đường Nguyễn Đáng, Phường 3, TP. Trà Vinh',
                    phone: '0294.3855.456',
                    rating: 4.6,
                    price: '22.000 - 30.000 VNĐ',
                    openTime: '5:30 - 21:30',
                    specialties: ['Bún nước lèo', 'Bún thịt nướng', 'Chả cá'],
                    image: 'images/quan-bun-nuoc-leo-chu-tam.jpg',
                    coordinates: { lat: 9.9356, lng: 106.3445 },
                    description: 'Nước dùng đậm đà, thịt tươi ngon, phục vụ nhiệt tình.'
                },
                {
                    id: 'bun-nuoc-leo-3',
                    name: 'Bún Nước Lèo Bà Năm',
                    address: '567 Đường Lê Duẩn, Phường 2, TP. Trà Vinh',
                    phone: '0294.3855.789',
                    rating: 4.5,
                    price: '20.000 - 28.000 VNĐ',
                    openTime: '6:30 - 21:00',
                    specialties: ['Bún nước lèo', 'Bánh canh', 'Chả cá thác lác'],
                    image: 'images/quan-bun-nuoc-leo-ba-nam.jpg',
                    coordinates: { lat: 9.9367, lng: 106.3456 },
                    description: 'Quán gia đình với công thức nước dùng truyền thống từ 3 đời.'
                }
            ],
            'bun-suong': [
                {
                    id: 'bun-suong-1',
                    name: 'Bún Suông Chú Năm',
                    address: '456 Đường Nguyễn Đáng, Phường 2, TP. Trà Vinh',
                    phone: '0294.3855.789',
                    rating: 4.6,
                    price: '20.000 - 30.000 VNĐ',
                    openTime: '6:00 - 20:00',
                    specialties: ['Bún suông', 'Bún tôm', 'Bánh canh tôm cua'],
                    image: 'images/quan-bun-suong-chu-nam.jpg',
                    coordinates: { lat: 9.9367, lng: 106.3456 },
                    description: 'Bún suông tươi ngon với nước dùng trong vắt và rau sống tươi mát.'
                },
                {
                    id: 'bun-suong-2',
                    name: 'Quán Bún Suông Bà Sáu',
                    address: 'Chợ Cầu Quan, Phường 4, TP. Trà Vinh',
                    phone: '0294.3855.321',
                    rating: 4.4,
                    price: '18.000 - 25.000 VNĐ',
                    openTime: '5:00 - 19:00',
                    specialties: ['Bún suông', 'Bún cá', 'Bánh ít lá gai'],
                    image: 'images/quan-bun-suong-ba-sau.jpg',
                    coordinates: { lat: 9.9378, lng: 106.3467 },
                    description: 'Quán gia đình với hương vị truyền thống, giá cả phải chăng.'
                }
            ],
            'banh-canh-ben-co': [
                {
                    id: 'banh-canh-1',
                    name: 'Bánh Canh Bến Có Cô Tư',
                    address: 'Bến Có, Huyện Trà Cú, Trà Vinh',
                    phone: '0294.3855.654',
                    rating: 4.7,
                    price: '20.000 - 28.000 VNĐ',
                    openTime: '6:00 - 18:00',
                    specialties: ['Bánh canh cua', 'Bánh canh tôm', 'Bánh canh chả cá'],
                    image: 'images/quan-banh-canh-ben-co-co-tu.jpg',
                    coordinates: { lat: 9.7456, lng: 106.2234 },
                    description: 'Bánh canh đặc sản vùng biển với cua tươi và tôm to, quán lâu đời nhất tại Bến Có.'
                },
                {
                    id: 'banh-canh-2',
                    name: 'Bánh Canh Cua Bà Năm',
                    address: 'Ấp Bến Có, Xã Long Đức, Trà Cú, Trà Vinh',
                    phone: '0294.3855.789',
                    rating: 4.5,
                    price: '18.000 - 25.000 VNĐ',
                    openTime: '5:30 - 17:30',
                    specialties: ['Bánh canh cua đồng', 'Bánh canh tôm sú', 'Canh chua cua'],
                    image: 'images/quan-banh-canh-cua-ba-nam.jpg',
                    coordinates: { lat: 9.7467, lng: 106.2245 },
                    description: 'Chuyên bánh canh cua đồng tươi ngon, nước dùng đậm đà từ cua xay nhuyễn.'
                },
                {
                    id: 'banh-canh-3',
                    name: 'Quán Bánh Canh Chú Sáu',
                    address: 'Chợ Trà Cú, Huyện Trà Cú, Trà Vinh',
                    phone: '0294.3855.321',
                    rating: 4.4,
                    price: '15.000 - 22.000 VNĐ',
                    openTime: '6:30 - 19:00',
                    specialties: ['Bánh canh', 'Bánh canh chả cá', 'Bún riêu cua'],
                    image: 'images/quan-banh-canh-chu-sau.jpg',
                    coordinates: { lat: 9.7478, lng: 106.2256 },
                    description: 'Quán gia đình với bánh canh truyền thống, giá cả phải chăng, phục vụ nhiệt tình.'
                },
                {
                    id: 'banh-canh-4',
                    name: 'Bánh Canh Hải Sản Cô Liên',
                    address: '234 Đường Trần Phú, Thị Trấn Trà Cú, Trà Vinh',
                    phone: '0294.3855.456',
                    rating: 4.6,
                    price: '22.000 - 35.000 VNĐ',
                    openTime: '7:00 - 20:00',
                    specialties: ['Bánh canh hải sản', 'Bánh canh cua ghẹ', 'Bánh canh tôm càng'],
                    image: 'images/quan-banh-canh-hai-san-co-lien.jpg',
                    coordinates: { lat: 9.7489, lng: 106.2267 },
                    description: 'Bánh canh hải sản cao cấp với cua ghẹ, tôm càng và các loại hải sản tươi sống.'
                }
            ],
            'chu-u-rang-me': [
                {
                    id: 'chu-u-1',
                    name: 'Chù Ụ Rang Me Bà Tư',
                    address: 'Chợ Cầu Quan, Phường 5, TP. Trà Vinh',
                    phone: '0294.3855.987',
                    rating: 4.2,
                    price: '15.000 - 25.000 VNĐ',
                    openTime: '15:00 - 22:00',
                    specialties: ['Chù ụ rang me', 'Chù ụ nướng', 'Bánh tráng nướng'],
                    image: 'images/quan-chu-u-ba-tu.jpg',
                    coordinates: { lat: 9.9389, lng: 106.3478 },
                    description: 'Món ăn vặt độc đáo với hương vị chua ngọt đặc trưng của người Khmer.'
                }
            ],
            'banh-xeo-khmer': [
                {
                    id: 'banh-xeo-1',
                    name: 'Bánh Xèo Khmer Cô Liên',
                    address: '789 Đường Lê Lợi, Phường 6, TP. Trà Vinh',
                    phone: '0294.3855.147',
                    rating: 4.5,
                    price: '15.000 - 25.000 VNĐ',
                    openTime: '16:00 - 23:00',
                    specialties: ['Bánh xèo Khmer', 'Bánh căn', 'Bánh khọt'],
                    image: 'images/quan-banh-xeo-co-lien.jpg',
                    coordinates: { lat: 9.9401, lng: 106.3489 },
                    description: 'Bánh xèo giòn rụm với nhân đầy đặn, ăn kèm rau sống tươi ngon.'
                }
            ],
            'nom-banh-chok': [
                {
                    id: 'nom-banh-chok-1',
                    name: 'Nom Banh Chok Chú Bảy',
                    address: '321 Đường Điện Biên Phủ, Phường 7, TP. Trà Vinh',
                    phone: '0294.3855.258',
                    rating: 4.3,
                    price: '12.000 - 20.000 VNĐ',
                    openTime: '5:00 - 11:00',
                    specialties: ['Nom banh chok', 'Bún tươi', 'Bánh ít'],
                    image: 'images/quan-nom-banh-chok.jpg',
                    coordinates: { lat: 9.9412, lng: 106.3501 },
                    description: 'Món ăn sáng truyền thống của người Khmer với bún tươi và nước mắm chua ngọt.'
                }
            ],
            
            // Thêm các món ăn mới
            'banh-it': [
                {
                    id: 'banh-it-1',
                    name: 'Bánh Ít Lá Gai Cô Sáu',
                    address: '234 Đường Trần Phú, Phường 4, TP. Trà Vinh',
                    phone: '0294.3855.369',
                    rating: 4.7,
                    price: '8.000 - 15.000 VNĐ',
                    openTime: '6:00 - 18:00',
                    specialties: ['Bánh ít lá gai', 'Bánh ít lá chuối', 'Bánh tét'],
                    image: 'images/quan-banh-it-co-sau.jpg',
                    coordinates: { lat: 9.9423, lng: 106.3512 },
                    description: 'Bánh ít truyền thống với lá gai tự nhiên, nhân đậu xanh thơm ngon.'
                },
                {
                    id: 'banh-it-2',
                    name: 'Bánh Ít Bà Tám',
                    address: 'Chợ Duyên Hải, Huyện Duyên Hải, Trà Vinh',
                    phone: '0294.3855.741',
                    rating: 4.4,
                    price: '6.000 - 12.000 VNĐ',
                    openTime: '5:30 - 17:00',
                    specialties: ['Bánh ít', 'Bánh căn', 'Bánh khọt'],
                    image: 'images/quan-banh-it-ba-tam.jpg',
                    coordinates: { lat: 9.8234, lng: 106.4567 },
                    description: 'Bánh ít làng quê với hương vị đậm đà, giá cả phải chăng.'
                }
            ],
            
            'banh-can': [
                {
                    id: 'banh-can-1',
                    name: 'Bánh Căn Cô Linh',
                    address: '456 Đường Nguyễn Thị Minh Khai, Phường 5, TP. Trà Vinh',
                    phone: '0294.3855.852',
                    rating: 4.6,
                    price: '15.000 - 25.000 VNĐ',
                    openTime: '15:00 - 22:00',
                    specialties: ['Bánh căn', 'Bánh khọt', 'Bánh xèo nhỏ'],
                    image: 'images/quan-banh-can-co-linh.jpg',
                    coordinates: { lat: 9.9434, lng: 106.3523 },
                    description: 'Bánh căn giòn rụm với tôm tươi, ăn kèm rau sống và nước chấm đặc biệt.'
                },
                {
                    id: 'banh-can-2',
                    name: 'Bánh Căn Chú Chín',
                    address: '789 Đường Lý Thường Kiệt, Phường 6, TP. Trà Vinh',
                    phone: '0294.3855.963',
                    rating: 4.3,
                    price: '12.000 - 20.000 VNĐ',
                    openTime: '16:00 - 23:00',
                    specialties: ['Bánh căn tôm', 'Bánh căn thịt', 'Bánh tráng nướng'],
                    image: 'images/quan-banh-can-chu-chin.jpg',
                    coordinates: { lat: 9.9445, lng: 106.3534 },
                    description: 'Bánh căn nóng hổi với nhiều loại nhân, phục vụ tận tình.'
                }
            ],
            
            'che-khmer': [
                {
                    id: 'che-khmer-1',
                    name: 'Chè Khmer Cô Hạnh',
                    address: '123 Đường Phan Bội Châu, Phường 3, TP. Trà Vinh',
                    phone: '0294.3855.147',
                    rating: 4.5,
                    price: '10.000 - 18.000 VNĐ',
                    openTime: '14:00 - 21:00',
                    specialties: ['Chè thái', 'Chè ba màu', 'Chè đậu xanh'],
                    image: 'images/quan-che-khmer-co-hanh.jpg',
                    coordinates: { lat: 9.9456, lng: 106.3545 },
                    description: 'Chè Khmer truyền thống với nhiều loại đậu và nước cốt dừa thơm ngon.'
                },
                {
                    id: 'che-khmer-2',
                    name: 'Chè Thái Bà Mười',
                    address: '567 Đường Võ Thị Sáu, Phường 8, TP. Trà Vinh',
                    phone: '0294.3855.258',
                    rating: 4.2,
                    price: '8.000 - 15.000 VNĐ',
                    openTime: '13:00 - 20:00',
                    specialties: ['Chè thái', 'Chè sương sa', 'Bánh flan'],
                    image: 'images/quan-che-thai-ba-muoi.jpg',
                    coordinates: { lat: 9.9467, lng: 106.3556 },
                    description: 'Chè thái mát lạnh với nhiều topping, phù hợp thời tiết nóng bức.'
                }
            ],
            
            'banh-trang-nuong': [
                {
                    id: 'banh-trang-nuong-1',
                    name: 'Bánh Tráng Nướng Cô Út',
                    address: '890 Đường Hùng Vương, Phường 9, TP. Trà Vinh',
                    phone: '0294.3855.369',
                    rating: 4.4,
                    price: '5.000 - 12.000 VNĐ',
                    openTime: '16:00 - 23:00',
                    specialties: ['Bánh tráng nướng', 'Bánh tráng phơi sương', 'Bánh tráng mắm ruốc'],
                    image: 'images/quan-banh-trang-nuong-co-ut.jpg',
                    coordinates: { lat: 9.9478, lng: 106.3567 },
                    description: 'Bánh tráng nướng giòn tan với trứng cút và các loại gia vị đậm đà.'
                }
            ],
            
            'com-tam': [
                {
                    id: 'com-tam-1',
                    name: 'Cơm Tấm Sườn Nướng Anh Hai',
                    address: '345 Đường Nguyễn Huệ, Phường 1, TP. Trà Vinh',
                    phone: '0294.3855.741',
                    rating: 4.6,
                    price: '25.000 - 40.000 VNĐ',
                    openTime: '10:00 - 22:00',
                    specialties: ['Cơm tấm sườn nướng', 'Cơm tấm bì chả', 'Cơm tấm gà nướng'],
                    image: 'images/quan-com-tam-anh-hai.jpg',
                    coordinates: { lat: 9.9489, lng: 106.3578 },
                    description: 'Cơm tấm sườn nướng thơm lừng với nước mắm pha chua ngọt đặc trưng.'
                },
                {
                    id: 'com-tam-2',
                    name: 'Cơm Tấm Chị Ba',
                    address: '678 Đường Trần Hưng Đạo, Phường 2, TP. Trà Vinh',
                    phone: '0294.3855.852',
                    rating: 4.3,
                    price: '20.000 - 35.000 VNĐ',
                    openTime: '11:00 - 21:30',
                    specialties: ['Cơm tấm', 'Cơm bình dân', 'Canh chua'],
                    image: 'images/quan-com-tam-chi-ba.jpg',
                    coordinates: { lat: 9.9501, lng: 106.3589 },
                    description: 'Quán cơm tấm gia đình với khẩu phần no, giá cả hợp lý.'
                }
            ],
            
            'hu-tieu': [
                {
                    id: 'hu-tieu-1',
                    name: 'Hủ Tiếu Nam Vang Chú Sáu',
                    address: '234 Đường Lê Lợi, Phường 4, TP. Trà Vinh',
                    phone: '0294.3855.963',
                    rating: 4.7,
                    price: '18.000 - 28.000 VNĐ',
                    openTime: '6:00 - 14:00',
                    specialties: ['Hủ tiếu Nam Vang', 'Hủ tiếu khô', 'Hủ tiếu gõ'],
                    image: 'images/quan-hu-tieu-chu-sau.jpg',
                    coordinates: { lat: 9.9512, lng: 106.3601 },
                    description: 'Hủ tiếu Nam Vang đậm đà với tôm tươi, thịt heo và gan heo.'
                }
            ],
            
            'banh-mi': [
                {
                    id: 'banh-mi-1',
                    name: 'Bánh Mì Thịt Nướng Cô Tư',
                    address: '456 Đường Điện Biên Phủ, Phường 5, TP. Trà Vinh',
                    phone: '0294.3855.147',
                    rating: 4.5,
                    price: '12.000 - 20.000 VNĐ',
                    openTime: '6:00 - 10:00, 15:00 - 19:00',
                    specialties: ['Bánh mì thịt nướng', 'Bánh mì pate', 'Bánh mì chả cá'],
                    image: 'images/quan-banh-mi-co-tu.jpg',
                    coordinates: { lat: 9.9523, lng: 106.3612 },
                    description: 'Bánh mì giòn rụm với thịt nướng thơm lừng và rau sống tươi ngon.'
                }
            ],
            
            'ca-loc-nuong-trui': [
                {
                    id: 'ca-loc-nuong-1',
                    name: 'Cá Lóc Nướng Trui Bà Bảy',
                    address: 'Ấp Tân Thành, Xã Long Đức, Trà Cú, Trà Vinh',
                    phone: '0294.3855.258',
                    rating: 4.8,
                    price: '150.000 - 250.000 VNĐ/kg',
                    openTime: '10:00 - 22:00',
                    specialties: ['Cá lóc nướng trui', 'Canh chua cá lóc', 'Gỏi cá lóc'],
                    image: 'images/quan-ca-loc-nuong-ba-bay.jpg',
                    coordinates: { lat: 9.7456, lng: 106.2234 },
                    description: 'Cá lóc nướng trui đặc sản vùng sông nước, thịt cá ngọt tự nhiên.'
                }
            ],
            
            'lau-mam': [
                {
                    id: 'lau-mam-1',
                    name: 'Lẩu Mắm Cô Chín',
                    address: '789 Đường Nguyễn Văn Cừ, Phường 7, TP. Trà Vinh',
                    phone: '0294.3855.369',
                    rating: 4.4,
                    price: '80.000 - 150.000 VNĐ/người',
                    openTime: '17:00 - 23:00',
                    specialties: ['Lẩu mắm', 'Lẩu cá kèo', 'Lẩu cá linh'],
                    image: 'images/quan-lau-mam-co-chin.jpg',
                    coordinates: { lat: 9.9534, lng: 106.3623 },
                    description: 'Lẩu mắm đậm đà hương vị miền Tây với nhiều loại rau rừng.'
                }
            ],
            
            // ===== ĐỒ UỐNG =====
            'ca-phe-sua-da': [
                {
                    id: 'ca-phe-1',
                    name: 'Cà Phê Sông Cửu Long',
                    address: 'Bờ sông Cửu Long, Phường 1, TP. Trà Vinh',
                    phone: '0294.3855.111',
                    rating: 4.7,
                    price: '15.000 - 30.000 VNĐ',
                    openTime: '6:00 - 23:00',
                    specialties: ['Cà phê sữa đá', 'Cà phê đen', 'Bạc xỉu', 'Cà phê dừa'],
                    image: 'images/cafe-song-cuu-long.jpg',
                    coordinates: { lat: 9.9345, lng: 106.3421 },
                    description: 'Quán cafe view sông đẹp, cà phê phin truyền thống đậm đà.'
                },
                {
                    id: 'ca-phe-2',
                    name: 'Highlands Coffee Trà Vinh',
                    address: '234 Đường Phạm Thái Bường, Phường 4, TP. Trà Vinh',
                    phone: '0294.3855.222',
                    rating: 4.5,
                    price: '25.000 - 55.000 VNĐ',
                    openTime: '7:00 - 22:30',
                    specialties: ['Cà phê phin', 'Freeze', 'Trà sữa', 'Bánh ngọt'],
                    image: 'images/highlands-coffee.jpg',
                    coordinates: { lat: 9.9356, lng: 106.3445 },
                    description: 'Chuỗi cà phê nổi tiếng với không gian hiện đại, đa dạng thức uống.'
                },
                {
                    id: 'ca-phe-3',
                    name: 'Cà Phê Vườn Xanh',
                    address: '567 Đường Lê Lợi, Phường 5, TP. Trà Vinh',
                    phone: '0294.3855.333',
                    rating: 4.4,
                    price: '12.000 - 25.000 VNĐ',
                    openTime: '6:30 - 22:00',
                    specialties: ['Cà phê sữa', 'Cà phê đen', 'Trà đá', 'Nước chanh'],
                    image: 'images/cafe-vuon-xanh.jpg',
                    coordinates: { lat: 9.9367, lng: 106.3456 },
                    description: 'Quán cà phê vỉa hè truyền thống, giá cả bình dân, phục vụ nhanh.'
                }
            ],
            
            'nuoc-mia': [
                {
                    id: 'nuoc-mia-1',
                    name: 'Nước Mía Chợ Trà Vinh',
                    address: 'Chợ Trà Vinh, Phường 1, TP. Trà Vinh',
                    phone: '0294.3855.444',
                    rating: 4.6,
                    price: '8.000 - 15.000 VNĐ',
                    openTime: '6:00 - 18:00',
                    specialties: ['Nước mía', 'Nước mía dầm', 'Nước mía chanh', 'Nước mía kumquat'],
                    image: 'images/nuoc-mia-cho.jpg',
                    coordinates: { lat: 9.9378, lng: 106.3467 },
                    description: 'Nước mía tươi mát, ngọt thanh, giải nhiệt tuyệt vời. Ép tươi ngay tại chỗ.'
                },
                {
                    id: 'nuoc-mia-2',
                    name: 'Nước Mía Cô Ba',
                    address: '123 Đường Nguyễn Đáng, Phường 3, TP. Trà Vinh',
                    phone: '0294.3855.555',
                    rating: 4.3,
                    price: '7.000 - 12.000 VNĐ',
                    openTime: '7:00 - 19:00',
                    specialties: ['Nước mía nguyên chất', 'Nước mía chanh dây', 'Nước mía sữa'],
                    image: 'images/nuoc-mia-co-ba.jpg',
                    coordinates: { lat: 9.9389, lng: 106.3478 },
                    description: 'Nước mía sạch, mía ngọt tự nhiên, không pha trộn. Giá cả phải chăng.'
                },
                {
                    id: 'nuoc-mia-3',
                    name: 'Nước Mía Bến Xe',
                    address: 'Bến xe Trà Vinh, Phường 9, TP. Trà Vinh',
                    phone: '0294.3855.666',
                    rating: 4.2,
                    price: '6.000 - 10.000 VNĐ',
                    openTime: '5:00 - 20:00',
                    specialties: ['Nước mía', 'Nước chanh', 'Nước cam'],
                    image: 'images/nuoc-mia-ben-xe.jpg',
                    coordinates: { lat: 9.9401, lng: 106.3489 },
                    description: 'Nước mía giá rẻ, phục vụ nhanh, tiện lợi cho khách đi xe.'
                }
            ],
            
            'tra-sua': [
                {
                    id: 'tra-sua-1',
                    name: 'Trà Sữa Gong Cha',
                    address: '345 Đường Phạm Thái Bường, Phường 2, TP. Trà Vinh',
                    phone: '0294.3855.777',
                    rating: 4.8,
                    price: '25.000 - 45.000 VNĐ',
                    openTime: '8:00 - 22:00',
                    specialties: ['Trà sữa trân châu', 'Trà sữa kem cheese', 'Trà hoa quả', 'Trà sữa matcha'],
                    image: 'images/tra-sua-gong-cha.jpg',
                    coordinates: { lat: 9.9412, lng: 106.3501 },
                    description: 'Thương hiệu trà sữa nổi tiếng với chất lượng cao, topping đa dạng.'
                },
                {
                    id: 'tra-sua-2',
                    name: 'Trà Sữa Ding Tea',
                    address: '678 Đường Lê Lợi, Phường 6, TP. Trà Vinh',
                    phone: '0294.3855.888',
                    rating: 4.6,
                    price: '20.000 - 40.000 VNĐ',
                    openTime: '8:30 - 22:30',
                    specialties: ['Trà sữa Đài Loan', 'Trà sữa socola', 'Trà sữa dâu', 'Trà sữa khoai môn'],
                    image: 'images/tra-sua-ding-tea.jpg',
                    coordinates: { lat: 9.9423, lng: 106.3512 },
                    description: 'Trà sữa Đài Loan chính gốc với hương vị đặc trưng, không gian trẻ trung.'
                },
                {
                    id: 'tra-sua-3',
                    name: 'Trà Sữa TocoToco',
                    address: '890 Đường Trần Phú, Phường 7, TP. Trà Vinh',
                    phone: '0294.3855.999',
                    rating: 4.5,
                    price: '18.000 - 38.000 VNĐ',
                    openTime: '9:00 - 23:00',
                    specialties: ['Trà sữa trân châu đường đen', 'Trà sữa thạch', 'Trà hoa quả nhiệt đới'],
                    image: 'images/tra-sua-tocotoco.jpg',
                    coordinates: { lat: 9.9434, lng: 106.3523 },
                    description: 'Chuỗi trà sữa phổ biến với giá cả hợp lý, nhiều ưu đãi.'
                },
                {
                    id: 'tra-sua-4',
                    name: 'Trà Sữa Phúc Long',
                    address: '234 Đường Điện Biên Phủ, Phường 8, TP. Trà Vinh',
                    phone: '0294.3855.101',
                    rating: 4.7,
                    price: '30.000 - 50.000 VNĐ',
                    openTime: '7:30 - 22:00',
                    specialties: ['Trà sữa ô long', 'Trà sữa hoa nhài', 'Cà phê', 'Bánh ngọt'],
                    image: 'images/tra-sua-phuc-long.jpg',
                    coordinates: { lat: 9.9445, lng: 106.3534 },
                    description: 'Thương hiệu trà sữa cao cấp với trà nguyên chất, không gian sang trọng.'
                }
            ],
            
            'sinh-to-bo': [
                {
                    id: 'sinh-to-1',
                    name: 'Sinh Tố Bơ Cô Linh',
                    address: '456 Đường Nguyễn Huệ, Phường 3, TP. Trà Vinh',
                    phone: '0294.3855.121',
                    rating: 4.7,
                    price: '25.000 - 40.000 VNĐ',
                    openTime: '10:00 - 22:00',
                    specialties: ['Sinh tố bơ', 'Sinh tố dâu', 'Sinh tố xoài', 'Sinh tố mãng cầu'],
                    image: 'images/sinh-to-co-linh.jpg',
                    coordinates: { lat: 9.9456, lng: 106.3545 },
                    description: 'Sinh tố bơ béo ngậy, thơm ngon và bổ dưỡng. Bơ tươi ngon, xay nhuyễn.'
                },
                {
                    id: 'sinh-to-2',
                    name: 'Sinh Tố Hoa Quả Tươi',
                    address: '789 Đường Trần Hưng Đạo, Phường 4, TP. Trà Vinh',
                    phone: '0294.3855.131',
                    rating: 4.5,
                    price: '20.000 - 35.000 VNĐ',
                    openTime: '9:00 - 21:00',
                    specialties: ['Sinh tố bơ', 'Sinh tố sapoche', 'Sinh tố dừa', 'Sinh tố mix'],
                    image: 'images/sinh-to-hoa-qua.jpg',
                    coordinates: { lat: 9.9467, lng: 106.3556 },
                    description: 'Sinh tố từ hoa quả tươi ngon, giá cả hợp lý, phục vụ nhanh chóng.'
                },
                {
                    id: 'sinh-to-3',
                    name: 'Sinh Tố Chợ Trà Vinh',
                    address: 'Chợ Trà Vinh, Phường 1, TP. Trà Vinh',
                    phone: '0294.3855.141',
                    rating: 4.3,
                    price: '15.000 - 30.000 VNĐ',
                    openTime: '7:00 - 18:00',
                    specialties: ['Sinh tố bơ', 'Sinh tố đu đủ', 'Sinh tố chuối', 'Nước ép'],
                    image: 'images/sinh-to-cho.jpg',
                    coordinates: { lat: 9.9478, lng: 106.3567 },
                    description: 'Sinh tố giá rẻ tại chợ, hoa quả tươi ngon, xay tại chỗ.'
                }
            ],
            
            // ===== BÁNH NGỌT & TRÁNG MIỆNG =====
            'kem-dua': [
                {
                    id: 'kem-dua-1',
                    name: 'Kem Dừa Bến Có',
                    address: 'Bến Có, Huyện Trà Cú, Trà Vinh',
                    phone: '0294.3855.151',
                    rating: 4.8,
                    price: '10.000 - 25.000 VNĐ',
                    openTime: '8:00 - 20:00',
                    specialties: ['Kem dừa', 'Kem dừa sầu riêng', 'Kem dừa cacao', 'Nước dừa tươi'],
                    image: 'images/kem-dua-ben-co.jpg',
                    coordinates: { lat: 9.7456, lng: 106.2234 },
                    description: 'Kem dừa mát lạnh với vị ngọt thanh của dừa tươi. Đặc sản vùng biển.'
                },
                {
                    id: 'kem-dua-2',
                    name: 'Kem Dừa Cô Út',
                    address: '123 Đường Võ Thị Sáu, Phường 5, TP. Trà Vinh',
                    phone: '0294.3855.161',
                    rating: 4.4,
                    price: '8.000 - 20.000 VNĐ',
                    openTime: '9:00 - 21:00',
                    specialties: ['Kem dừa', 'Kem dừa thạch', 'Kem dừa trân châu'],
                    image: 'images/kem-dua-co-ut.jpg',
                    coordinates: { lat: 9.9489, lng: 106.3578 },
                    description: 'Kem dừa làm từ nước cốt dừa tươi, béo ngậy và thơm ngon.'
                }
            ],
            
            'banh-flan': [
                {
                    id: 'banh-flan-1',
                    name: 'Bánh Flan Cô Hạnh',
                    address: '456 Đường Phan Bội Châu, Phường 6, TP. Trà Vinh',
                    phone: '0294.3855.171',
                    rating: 4.6,
                    price: '8.000 - 18.000 VNĐ',
                    openTime: '13:00 - 21:00',
                    specialties: ['Bánh flan', 'Bánh flan cà phê', 'Bánh flan dừa', 'Chè'],
                    image: 'images/banh-flan-co-hanh.jpg',
                    coordinates: { lat: 9.9501, lng: 106.3589 },
                    description: 'Bánh flan mềm mịn với lớp caramel ngọt đắng hài hòa.'
                }
            ],
            
            'banh-tet-tra-cuon': [
                {
                    id: 'banh-tet-1',
                    name: 'Bánh Tét Trà Cuôn Bà Năm',
                    address: 'Xã Trà Cuôn, Huyện Trà Cú, Trà Vinh',
                    phone: '0294.3855.181',
                    rating: 4.9,
                    price: '30.000 - 60.000 VNĐ/cái',
                    openTime: '6:00 - 18:00 (Mùa Tết)',
                    specialties: ['Bánh tét', 'Bánh tét nhân đậu', 'Bánh tét nhân chuối'],
                    image: 'images/banh-tet-tra-cuon.jpg',
                    coordinates: { lat: 9.7234, lng: 106.2123 },
                    description: 'Bánh tét đặc sản Trà Cuôn với nhân đậu xanh và thịt heo thơm ngon.'
                }
            ],
            
            'loi-choi-xa-ot': [
                {
                    id: 'loi-choi-1',
                    name: 'Lợi Choi Xã Ớt Cô Sáu',
                    address: 'Xã Ớt, Huyện Càng Long, Trà Vinh',
                    phone: '0294.3855.191',
                    rating: 4.5,
                    price: '20.000 - 40.000 VNĐ',
                    openTime: '10:00 - 20:00',
                    specialties: ['Lợi choi xào tỏi', 'Lợi choi nấu canh', 'Lợi choi luộc'],
                    image: 'images/loi-choi-xa-ot.jpg',
                    coordinates: { lat: 9.8567, lng: 106.2789 },
                    description: 'Món ăn đặc sản độc đáo của vùng Xã Ớt với vị đắng nhẹ, thanh mát.'
                }
            ]
        };
    }

    // Mở modal tìm quán
    openRestaurantModal(foodType) {
        console.log('🔍 Opening restaurant finder for:', foodType);
        
        this.currentFood = foodType;
        const restaurants = this.restaurants[foodType] || [];
        
        if (restaurants.length === 0) {
            alert('🔍 Hiện tại chưa có thông tin quán ăn cho món này.\n\nChúng tôi sẽ cập nhật sớm nhất!');
            return;
        }

        const modalHTML = this.createRestaurantModalHTML(foodType, restaurants);
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        this.setupModalEvents();
    }

    // Tạo HTML modal
    createRestaurantModalHTML(foodType, restaurants) {
        const foodNames = {
            // Món chính
            'bun-nuoc-leo': 'Bún Nước Lèo',
            'bun-suong': 'Bún Suông',
            'banh-canh-ben-co': 'Bánh Canh Bến Có',
            'nom-banh-chok': 'Nom Banh Chok',
            'ca-loc-nuong-trui': 'Cá Lóc Nướng Trui',
            'lau-mam': 'Lẩu Mắm',
            'com-tam-suon-nuong': 'Cơm Tấm Sườn Nướng',
            'com-tam': 'Cơm Tấm',
            'hu-tieu-my-tho': 'Hủ Tiếu Mỹ Tho',
            'hu-tieu': 'Hủ Tiếu',
            
            // Món ăn vặt
            'chu-u-rang-me': 'Chù Ụ Rang Me',
            'banh-xeo-khmer': 'Bánh Xèo Khmer',
            'loi-choi-xa-ot': 'Lợi Choi Xã Ớt',
            'banh-mi-thit': 'Bánh Mì Thịt',
            'banh-mi': 'Bánh Mì',
            
            // Bánh ngọt
            'che-khmer': 'Chè Khmer',
            'banh-tet-tra-cuon': 'Bánh Tét Trà Cuôn',
            'banh-it-la-gai': 'Bánh Ít Lá Gai',
            'banh-it': 'Bánh Ít',
            'kem-dua': 'Kem Dừa',
            'banh-flan': 'Bánh Flan',
            'banh-can': 'Bánh Căn',
            'banh-trang-nuong': 'Bánh Tráng Nướng',
            
            // Đồ uống
            'ca-phe-sua-da': 'Cà Phê Sữa Đá',
            'nuoc-mia': 'Nước Mía',
            'tra-sua': 'Trà Sữa',
            'sinh-to-bo': 'Sinh Tố Bơ'
        };

        const foodName = foodNames[foodType] || 'Món ăn';
        
        return `
            <div class="restaurant-modal-overlay" id="restaurantModal" onclick="restaurantFinder.closeModal()">
                <div class="restaurant-modal-content" onclick="event.stopPropagation()">
                    <div class="restaurant-modal-header">
                        <h2>🍽️ Tìm Quán ${foodName}</h2>
                        <button class="restaurant-close-btn" onclick="restaurantFinder.closeModal()">&times;</button>
                    </div>
                    
                    <div class="restaurant-modal-body">
                        <div class="restaurant-summary">
                            <p>Tìm thấy <strong>${restaurants.length}</strong> quán phục vụ ${foodName} tại Trà Vinh</p>
                        </div>
                        
                        <div class="restaurant-list">
                            ${restaurants.map(restaurant => this.createRestaurantCard(restaurant)).join('')}
                        </div>
                    </div>
                    
                    <div class="restaurant-modal-footer">
                        <button class="btn-secondary" onclick="restaurantFinder.closeModal()">
                            <i class="fas fa-times"></i>
                            Đóng
                        </button>
                        <button class="btn-primary" onclick="restaurantFinder.showAllOnMap()">
                            <i class="fas fa-map"></i>
                            Xem Trên Bản Đồ
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Tạo card quán ăn
    createRestaurantCard(restaurant) {
        const stars = this.generateStars(restaurant.rating);
        
        return `
            <div class="restaurant-card">
                <div class="restaurant-image">
                    <img src="${restaurant.image}" alt="${restaurant.name}" 
                         onerror="this.src='images/placeholder-restaurant.jpg'">
                    <div class="restaurant-rating">
                        <span class="rating-number">${restaurant.rating}</span>
                        <div class="rating-stars">${stars}</div>
                    </div>
                </div>
                
                <div class="restaurant-info">
                    <h3 class="restaurant-name">${restaurant.name}</h3>
                    <div class="restaurant-details">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${restaurant.address}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span>${restaurant.phone}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>${restaurant.openTime}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>${restaurant.price}</span>
                        </div>
                    </div>
                    
                    <div class="restaurant-specialties">
                        <strong>Món đặc biệt:</strong>
                        <div class="specialty-tags">
                            ${restaurant.specialties.map(specialty => 
                                `<span class="specialty-tag">${specialty}</span>`
                            ).join('')}
                        </div>
                    </div>
                    
                    <p class="restaurant-description">${restaurant.description}</p>
                    
                    <div class="restaurant-actions">
                        <button class="btn-action btn-call" onclick="restaurantFinder.callRestaurant('${restaurant.phone}')">
                            <i class="fas fa-phone"></i>
                            Gọi Điện
                        </button>
                        <button class="btn-action btn-direction" onclick="restaurantFinder.getDirections('${restaurant.id}')">
                            <i class="fas fa-directions"></i>
                            Chỉ Đường
                        </button>
                        <button class="btn-action btn-share" onclick="restaurantFinder.shareRestaurant('${restaurant.id}')">
                            <i class="fas fa-share"></i>
                            Chia Sẻ
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Tạo sao đánh giá
    generateStars(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
        
        let stars = '';
        
        // Sao đầy
        for (let i = 0; i < fullStars; i++) {
            stars += '<i class="fas fa-star"></i>';
        }
        
        // Sao nửa
        if (hasHalfStar) {
            stars += '<i class="fas fa-star-half-alt"></i>';
        }
        
        // Sao rỗng
        for (let i = 0; i < emptyStars; i++) {
            stars += '<i class="far fa-star"></i>';
        }
        
        return stars;
    }

    // Thiết lập sự kiện modal
    setupModalEvents() {
        // Thêm animation
        const modal = document.getElementById('restaurantModal');
        if (modal) {
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }
    }

    // Đóng modal
    closeModal() {
        const modal = document.getElementById('restaurantModal');
        if (modal) {
            modal.classList.add('closing');
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
        this.currentFood = null;
    }

    // Gọi điện thoại
    callRestaurant(phone) {
        if (confirm(`📞 Bạn có muốn gọi điện đến số ${phone}?`)) {
            window.open(`tel:${phone}`);
        }
    }

    // Chỉ đường
    getDirections(restaurantId) {
        const restaurant = this.findRestaurantById(restaurantId);
        if (restaurant) {
            const { lat, lng } = restaurant.coordinates;
            const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
            window.open(googleMapsUrl, '_blank');
        }
    }

    // Chia sẻ quán
    shareRestaurant(restaurantId) {
        const restaurant = this.findRestaurantById(restaurantId);
        if (restaurant) {
            const shareText = `🍽️ ${restaurant.name}\n📍 ${restaurant.address}\n⭐ ${restaurant.rating}/5\n💰 ${restaurant.price}`;
            
            if (navigator.share) {
                navigator.share({
                    title: restaurant.name,
                    text: shareText,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(shareText).then(() => {
                    alert('✅ Đã sao chép thông tin quán vào clipboard!');
                });
            }
        }
    }

    // Hiển thị tất cả trên bản đồ
    showAllOnMap() {
        const restaurants = this.restaurants[this.currentFood] || [];
        if (restaurants.length === 0) return;
        
        // Tạo URL Google Maps với nhiều điểm
        const waypoints = restaurants.map(r => `${r.coordinates.lat},${r.coordinates.lng}`).join('|');
        const mapUrl = `https://www.google.com/maps/search/?api=1&query=${waypoints}`;
        
        window.open(mapUrl, '_blank');
    }

    // Tìm quán theo ID
    findRestaurantById(restaurantId) {
        for (const foodType in this.restaurants) {
            const restaurant = this.restaurants[foodType].find(r => r.id === restaurantId);
            if (restaurant) return restaurant;
        }
        return null;
    }

    // Tìm quán theo tên món ăn
    findRestaurantsByFood(foodName) {
        const foodMap = {
            // Món chính
            'Bún Nước Lèo': 'bun-nuoc-leo',
            'Bún Suông': 'bun-suong',
            'Bánh Canh Bến Có': 'banh-canh-ben-co',
            'Nom Banh Chok': 'nom-banh-chok',
            'Cá Lóc Nướng Trui': 'ca-loc-nuong-trui',
            'Lẩu Mắm': 'lau-mam',
            'Cơm Tấm Sườn Nướng': 'com-tam-suon-nuong',
            'Cơm Tấm': 'com-tam',
            'Hủ Tiếu Mỹ Tho': 'hu-tieu-my-tho',
            'Hủ Tiếu': 'hu-tieu',
            
            // Món ăn vặt
            'Chù Ụ Rang Me': 'chu-u-rang-me',
            'Bánh Xèo Khmer': 'banh-xeo-khmer',
            'Lợi Choi Xã Ớt': 'loi-choi-xa-ot',
            'Bánh Mì Thịt': 'banh-mi-thit',
            'Bánh Mì': 'banh-mi',
            
            // Bánh ngọt
            'Chè Khmer': 'che-khmer',
            'Bánh Tét Trà Cuôn': 'banh-tet-tra-cuon',
            'Bánh Ít Lá Gai': 'banh-it-la-gai',
            'Bánh Ít': 'banh-it',
            'Kem Dừa': 'kem-dua',
            'Bánh Flan': 'banh-flan',
            'Bánh Căn': 'banh-can',
            'Bánh Tráng Nướng': 'banh-trang-nuong',
            
            // Đồ uống
            'Cà Phê Sữa Đá': 'ca-phe-sua-da',
            'Nước Mía': 'nuoc-mia',
            'Trà Sữa': 'tra-sua',
            'Sinh Tố Bơ': 'sinh-to-bo'
        };
        
        const foodType = foodMap[foodName];
        return foodType ? this.restaurants[foodType] || [] : [];
    }
}

// Khởi tạo hệ thống
const restaurantFinder = new RestaurantFinder();

// Export cho global scope
window.restaurantFinder = restaurantFinder;
window.findRestaurants = (foodType) => restaurantFinder.openRestaurantModal(foodType);

console.log('✅ Restaurant Finder loaded successfully!');