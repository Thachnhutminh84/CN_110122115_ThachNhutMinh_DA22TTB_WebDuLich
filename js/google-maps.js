/**
 * Google Maps Integration cho Địa Điểm Du Lịch
 */

let map;
let marker;
let infoWindow;

/**
 * Khởi tạo Google Map
 */
function initMap(lat, lng, title, address) {
    // Tọa độ mặc định (Trà Vinh) nếu không có dữ liệu
    const defaultLat = lat || 9.9347;
    const defaultLng = lng || 106.3428;
    
    const location = { lat: parseFloat(defaultLat), lng: parseFloat(defaultLng) };
    
    console.log('🗺️ Initializing map at:', location);

    // Tạo map
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: location,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: true,
        zoomControl: true,
        styles: [
            {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [{ visibility: 'on' }]
            }
        ]
    });

    // Tạo marker
    marker = new google.maps.Marker({
        position: location,
        map: map,
        title: title || 'Địa điểm du lịch',
        animation: google.maps.Animation.DROP,
        icon: {
            url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
            scaledSize: new google.maps.Size(40, 40)
        }
    });

    // Tạo info window
    const contentString = `
        <div style="padding: 10px; max-width: 250px;">
            <h3 style="margin: 0 0 10px 0; color: #1f2937; font-size: 16px;">
                <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i>
                ${title || 'Địa điểm'}
            </h3>
            <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 14px;">
                <i class="fas fa-location-dot" style="color: #3b82f6;"></i>
                ${address || 'Trà Vinh'}
            </p>
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <a href="https://www.google.com/maps/dir/?api=1&destination=${location.lat},${location.lng}" 
                   target="_blank"
                   style="display: inline-flex; align-items: center; gap: 5px; padding: 8px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; font-size: 13px;">
                    <i class="fas fa-directions"></i>
                    Chỉ đường
                </a>
                <a href="https://www.google.com/maps/search/?api=1&query=${location.lat},${location.lng}" 
                   target="_blank"
                   style="display: inline-flex; align-items: center; gap: 5px; padding: 8px 12px; background: #10b981; color: white; text-decoration: none; border-radius: 5px; font-size: 13px;">
                    <i class="fas fa-external-link-alt"></i>
                    Xem trên Maps
                </a>
            </div>
        </div>
    `;

    infoWindow = new google.maps.InfoWindow({
        content: contentString
    });

    // Hiển thị info window khi click marker
    marker.addListener('click', () => {
        infoWindow.open(map, marker);
    });

    // Tự động mở info window
    setTimeout(() => {
        infoWindow.open(map, marker);
    }, 500);

    console.log('✅ Map initialized successfully');
}

/**
 * Tìm địa điểm gần đây
 */
function findNearbyPlaces(lat, lng, type = 'tourist_attraction') {
    const location = new google.maps.LatLng(lat, lng);
    
    const request = {
        location: location,
        radius: 5000, // 5km
        type: [type]
    };

    const service = new google.maps.places.PlacesService(map);
    
    service.nearbySearch(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            console.log('📍 Found nearby places:', results.length);
            
            // Hiển thị các địa điểm gần đây
            results.slice(0, 5).forEach((place, index) => {
                const nearbyMarker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map,
                    title: place.name,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                        scaledSize: new google.maps.Size(30, 30)
                    }
                });

                const nearbyInfo = new google.maps.InfoWindow({
                    content: `
                        <div style="padding: 8px;">
                            <h4 style="margin: 0 0 5px 0; font-size: 14px;">${place.name}</h4>
                            <p style="margin: 0; font-size: 12px; color: #6b7280;">${place.vicinity}</p>
                        </div>
                    `
                });

                nearbyMarker.addListener('click', () => {
                    nearbyInfo.open(map, nearbyMarker);
                });
            });
        }
    });
}

/**
 * Lấy chỉ đường
 */
function getDirections(destLat, destLng) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const origin = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                const destination = { lat: destLat, lng: destLng };

                const directionsService = new google.maps.DirectionsService();
                const directionsRenderer = new google.maps.DirectionsRenderer({
                    map: map,
                    suppressMarkers: false
                });

                directionsService.route(
                    {
                        origin: origin,
                        destination: destination,
                        travelMode: google.maps.TravelMode.DRIVING
                    },
                    (response, status) => {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(response);
                            console.log('✅ Directions loaded');
                        } else {
                            console.error('❌ Directions request failed:', status);
                        }
                    }
                );
            },
            (error) => {
                console.error('❌ Geolocation error:', error);
                alert('Không thể lấy vị trí của bạn. Vui lòng bật GPS.');
            }
        );
    } else {
        alert('Trình duyệt không hỗ trợ Geolocation');
    }
}

/**
 * Geocode địa chỉ thành tọa độ
 */
function geocodeAddress(address, callback) {
    const geocoder = new google.maps.Geocoder();
    
    geocoder.geocode({ address: address + ', Trà Vinh, Vietnam' }, (results, status) => {
        if (status === 'OK') {
            const location = results[0].geometry.location;
            console.log('📍 Geocoded address:', address, '→', location.lat(), location.lng());
            
            if (callback) {
                callback(location.lat(), location.lng());
            }
        } else {
            console.error('❌ Geocode failed:', status);
        }
    });
}
