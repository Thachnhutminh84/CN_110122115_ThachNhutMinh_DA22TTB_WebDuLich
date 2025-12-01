// DateTime Display System
class DateTimeDisplay {
    constructor() {
        this.init();
        this.startClock();
    }

    init() {
        // Create datetime container if not exists
        this.createDateTimeContainer();
        
        // Update immediately
        this.updateDateTime();
        
        console.log('✅ DateTime system initialized');
    }

    createDateTimeContainer() {
        // Check if container already exists
        let container = document.getElementById('datetime-display');
        
        if (!container) {
            container = document.createElement('div');
            container.id = 'datetime-display';
            container.className = 'datetime-container';
            
            // Try to insert in header or create floating widget
            const header = document.querySelector('header');
            if (header) {
                header.appendChild(container);
            } else {
                // Create floating widget
                container.className += ' floating-datetime';
                document.body.appendChild(container);
            }
        }
        
        this.container = container;
    }

    updateDateTime() {
        const now = new Date();
        
        // Format time (24-hour format)
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        
        // Format date in Vietnamese
        const dayNames = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
        const dayName = dayNames[now.getDay()];
        
        const day = now.getDate();
        const month = now.getMonth() + 1;
        const year = now.getFullYear();
        
        const dateString = `${dayName}, ${day} tháng ${month}, ${year}`;
        
        // Update container
        this.container.innerHTML = `
            <div class="datetime-widget">
                <div class="time-display">
                    <i class="fas fa-clock"></i>
                    <span class="time">${timeString}</span>
                </div>
                <div class="date-display">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="date">${dateString}</span>
                </div>
            </div>
        `;
    }

    startClock() {
        // Update every second
        setInterval(() => {
            this.updateDateTime();
        }, 1000);
    }

    // Get formatted time for specific use
    getCurrentTime() {
        const now = new Date();
        return {
            time: now.toLocaleTimeString('vi-VN', { 
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }),
            date: now.toLocaleDateString('vi-VN', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }),
            timestamp: now.getTime(),
            iso: now.toISOString()
        };
    }

    // Format time for specific contexts
    formatTimeForContext(context = 'default') {
        const now = new Date();
        
        switch(context) {
            case 'header':
                return `lúc ${now.toLocaleTimeString('vi-VN', { hour12: false })} ${now.toLocaleDateString('vi-VN', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}`;
            
            case 'compact':
                return `${now.toLocaleTimeString('vi-VN', { hour12: false, hour: '2-digit', minute: '2-digit' })} - ${now.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' })}`;
            
            case 'full':
                return `${now.toLocaleTimeString('vi-VN', { hour12: false })} ${now.toLocaleDateString('vi-VN', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}`;
            
            default:
                return this.getCurrentTime();
        }
    }
}

// Utility functions for datetime
const DateTimeUtils = {
    // Get Vietnamese day name
    getVietnameseDayName(dayIndex) {
        const days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
        return days[dayIndex];
    },

    // Get Vietnamese month name
    getVietnameseMonthName(monthIndex) {
        const months = [
            'tháng 1', 'tháng 2', 'tháng 3', 'tháng 4', 'tháng 5', 'tháng 6',
            'tháng 7', 'tháng 8', 'tháng 9', 'tháng 10', 'tháng 11', 'tháng 12'
        ];
        return months[monthIndex];
    },

    // Format date for Vietnamese display
    formatVietnameseDate(date = new Date()) {
        const dayName = this.getVietnameseDayName(date.getDay());
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        
        return `${dayName}, ${day} tháng ${month}, ${year}`;
    },

    // Format time for Vietnamese display
    formatVietnameseTime(date = new Date()) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        
        return `${hours}:${minutes}:${seconds}`;
    },

    // Get time greeting
    getTimeGreeting() {
        const hour = new Date().getHours();
        
        if (hour < 6) return 'Chúc bạn đêm an lành';
        if (hour < 12) return 'Chào buổi sáng';
        if (hour < 18) return 'Chào buổi chiều';
        return 'Chào buổi tối';
    },

    // Check if it's business hours
    isBusinessHours() {
        const now = new Date();
        const hour = now.getHours();
        const day = now.getDay();
        
        // Monday to Friday, 8 AM to 5 PM
        return day >= 1 && day <= 5 && hour >= 8 && hour < 17;
    },

    // Get relative time
    getRelativeTime(date) {
        const now = new Date();
        const diff = now - date;
        const seconds = Math.floor(diff / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (days > 0) return `${days} ngày trước`;
        if (hours > 0) return `${hours} giờ trước`;
        if (minutes > 0) return `${minutes} phút trước`;
        return 'Vừa xong';
    }
};

// Header DateTime Integration
function addDateTimeToHeader() {
    const headers = document.querySelectorAll('header');
    
    headers.forEach(header => {
        // Check if datetime already exists
        if (header.querySelector('.header-datetime')) return;
        
        const datetimeElement = document.createElement('div');
        datetimeElement.className = 'header-datetime';
        
        // Try to insert in appropriate location
        const nav = header.querySelector('nav');
        if (nav) {
            nav.appendChild(datetimeElement);
        } else {
            header.appendChild(datetimeElement);
        }
        
        // Update datetime
        function updateHeaderDateTime() {
            const timeInfo = DateTimeUtils.formatVietnameseDate();
            const timeString = DateTimeUtils.formatVietnameseTime();
            
            datetimeElement.innerHTML = `
                <div class="header-time">
                    <i class="fas fa-clock text-blue-600"></i>
                    <span class="time-text">${timeString}</span>
                </div>
                <div class="header-date">
                    <i class="fas fa-calendar text-green-600"></i>
                    <span class="date-text">${timeInfo}</span>
                </div>
            `;
        }
        
        updateHeaderDateTime();
        setInterval(updateHeaderDateTime, 1000);
    });
}

// Initialize datetime system
let dateTimeSystem;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize main datetime system
    dateTimeSystem = new DateTimeDisplay();
    
    // Add to headers
    setTimeout(() => {
        addDateTimeToHeader();
    }, 100);
    
    console.log('🕐 DateTime system loaded');
});

// Export for global use
window.DateTimeDisplay = DateTimeDisplay;
window.DateTimeUtils = DateTimeUtils;
window.dateTimeSystem = dateTimeSystem;// 
Auto-update datetime in common elements
function initializePageDateTime() {
    // Update header datetime elements
    function updateHeaderElements() {
        const now = new Date();
        const timeStr = DateTimeUtils.formatVietnameseTime(now);
        const dateStr = DateTimeUtils.formatVietnameseDate(now);
        
        // Update common datetime elements
        const elements = {
            'headerTime': timeStr,
            'headerDate': dateStr,
            'currentDateTime': `${timeStr} ${dateStr}`,
            'universityTime': `lúc ${timeStr.substring(0, 5)}`,
            'universityDate': dateStr
        };
        
        Object.keys(elements).forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = elements[id];
            }
        });
        
        // Update business hours if element exists
        const businessElement = document.getElementById('businessHours');
        if (businessElement) {
            const isOpen = DateTimeUtils.isBusinessHours();
            businessElement.className = `business-hours-indicator ${isOpen ? 'business-hours-open' : 'business-hours-closed'}`;
            businessElement.innerHTML = `<i class="fas fa-circle"></i><span>${isOpen ? 'Đang mở cửa' : 'Đã đóng cửa'}</span>`;
        }
    }
    
    // Initial update
    updateHeaderElements();
    
    // Update every second
    setInterval(updateHeaderElements, 1000);
    
    console.log('🕐 Page datetime initialized');
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initializePageDateTime, 500);
});

// Also initialize when page is fully loaded
window.addEventListener('load', function() {
    setTimeout(initializePageDateTime, 1000);
});

console.log('✅ DateTime system fully loaded');