// Simple Admin Controls - Debug Version
console.log('🔧 Loading simple admin controls...');

// Global variables
let isAdminMode = false;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 DOM loaded, initializing admin controls...');
    
    // Add styles
    addAdminStyles();
    
    // Check if elements exist
    const adminToggle = document.getElementById('adminToggle');
    const adminToolbar = document.getElementById('adminToolbar');
    
    console.log('🔧 Admin toggle button:', adminToggle);
    console.log('🔧 Admin toolbar:', adminToolbar);
    
    if (adminToggle) {
        console.log('✅ Admin toggle button found');
        adminToggle.addEventListener('click', function() {
            console.log('🔧 Admin toggle clicked!');
            toggleAdminMode();
        });
    } else {
        console.error('❌ Admin toggle button not found!');
    }
    
    if (adminToolbar) {
        console.log('✅ Admin toolbar found');
    } else {
        console.error('❌ Admin toolbar not found!');
    }
    
    // Inject admin buttons into existing cards
    injectAdminButtons();
    
    console.log('✅ Simple admin controls initialized');
});

// Add basic styles
function addAdminStyles() {
    const styles = `
        <style id="simple-admin-styles">
            .admin-toggle-btn {
                background: #3b82f6;
                color: white;
                border: none;
                padding: 12px;
                border-radius: 50%;
                cursor: pointer;
                margin-left: 10px;
                transition: all 0.3s ease;
            }
            
            .admin-toggle-btn:hover {
                background: #2563eb;
                transform: scale(1.1);
            }
            
            .admin-toggle-btn.active {
                background: #f59e0b;
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            
            .admin-toolbar {
                background: #1f2937;
                color: white;
                padding: 1rem;
                position: sticky;
                top: 0;
                z-index: 40;
            }
            
            .admin-toolbar-content {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .admin-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 600;
            }
            
            .admin-actions {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }
            
            .btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 0.5rem;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
            }
            
            .btn-success {
                background: #10b981;
                color: white;
            }
            
            .btn-primary {
                background: #3b82f6;
                color: white;
            }
            
            .btn-secondary {
                background: #6b7280;
                color: white;
            }
            
            .btn-warning {
                background: #f59e0b;
                color: white;
            }
            
            .btn-danger {
                background: #ef4444;
                color: white;
            }
            
            .btn:hover {
                transform: translateY(-1px);
                opacity: 0.9;
            }
            
            .hidden {
                display: none !important;
            }
            
            .admin-actions-card {
                display: flex;
                gap: 0.5rem;
                margin-top: 0.75rem;
                padding-top: 0.75rem;
                border-top: 1px solid #e5e7eb;
                justify-content: center;
            }
            
            .admin-mode .attraction-card,
            .admin-mode .featured-card {
                border: 2px dashed #3b82f6 !important;
                background: rgba(59, 130, 246, 0.05) !important;
            }
            
            .card-btn {
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 0.5rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
            }
        </style>
    `;
    
    if (!document.getElementById('simple-admin-styles')) {
        document.head.insertAdjacentHTML('beforeend', styles);
        console.log('✅ Admin styles added');
    }
}

// Toggle admin mode
function toggleAdminMode() {
    console.log('🔧 toggleAdminMode called, current mode:', isAdminMode);
    
    isAdminMode = !isAdminMode;
    
    const toggleBtn = document.getElementById('adminToggle');
    const toolbar = document.getElementById('adminToolbar');
    const body = document.body;
    
    console.log('🔧 Elements found:', {
        toggleBtn: !!toggleBtn,
        toolbar: !!toolbar,
        body: !!body
    });
    
    if (isAdminMode) {
        console.log('🔧 Enabling admin mode...');
        
        // Enable admin mode
        if (toggleBtn) {
            toggleBtn.classList.add('active');
            console.log('✅ Toggle button activated');
        }
        
        if (toolbar) {
            toolbar.classList.remove('hidden');
            console.log('✅ Toolbar shown');
        }
        
        if (body) {
            body.classList.add('admin-mode');
            console.log('✅ Body admin mode added');
        }
        
        // Show all admin action buttons
        const adminActions = document.querySelectorAll('.admin-actions-card');
        console.log('🔧 Found admin action cards:', adminActions.length);
        
        adminActions.forEach(el => {
            el.classList.remove('hidden');
        });
        
        showNotification('Chế độ quản lý đã được bật', 'success');
        
    } else {
        console.log('🔧 Disabling admin mode...');
        
        // Disable admin mode
        if (toggleBtn) {
            toggleBtn.classList.remove('active');
        }
        
        if (toolbar) {
            toolbar.classList.add('hidden');
        }
        
        if (body) {
            body.classList.remove('admin-mode');
        }
        
        // Hide all admin action buttons
        const adminActions = document.querySelectorAll('.admin-actions-card');
        adminActions.forEach(el => {
            el.classList.add('hidden');
        });
        
        showNotification('Chế độ quản lý đã được tắt', 'info');
    }
    
    console.log('🔧 Admin mode toggled to:', isAdminMode);
}

// Inject admin buttons into existing cards
function injectAdminButtons() {
    console.log('🔧 Injecting admin buttons...');
    
    // Find all card actions
    const cardActions = document.querySelectorAll('.card-actions, .featured-actions');
    console.log('🔧 Found card actions:', cardActions.length);
    
    cardActions.forEach((actionContainer, index) => {
        // Try to find the attraction ID from onclick attributes
        const buttons = actionContainer.querySelectorAll('button[onclick*="Modal"]');
        let attractionId = null;
        
        for (let button of buttons) {
            const onclick = button.getAttribute('onclick');
            if (onclick) {
                const match = onclick.match(/'([^']+)'/);
                if (match) {
                    attractionId = match[1];
                    break;
                }
            }
        }
        
        // If no ID found, generate one based on index
        if (!attractionId) {
            attractionId = `attraction_${index}`;
        }
        
        console.log(`🔧 Processing card ${index}, ID: ${attractionId}`);
        
        // Check if admin actions already exist
        if (!actionContainer.querySelector(`#adminActions-${attractionId}`)) {
            const adminActions = document.createElement('div');
            adminActions.className = 'admin-actions-card hidden';
            adminActions.id = `adminActions-${attractionId}`;
            adminActions.innerHTML = `
                <button class="card-btn btn-warning" onclick="editAttraction('${attractionId}')">
                    <i class="fas fa-edit"></i>
                    Sửa
                </button>
                <button class="card-btn btn-danger" onclick="deleteAttraction('${attractionId}')">
                    <i class="fas fa-trash"></i>
                    Xóa
                </button>
            `;
            
            actionContainer.appendChild(adminActions);
            console.log(`✅ Added admin buttons for ${attractionId}`);
        }
    });
    
    console.log('✅ Admin buttons injection completed');
}

// Edit attraction function
function editAttraction(id) {
    console.log('🔧 Edit attraction:', id);
    
    const attraction = getAttractionData(id);
    showEditModal(id, attraction);
}

// Delete attraction function
function deleteAttraction(id) {
    console.log('🔧 Delete attraction:', id);
    
    const attraction = getAttractionData(id);
    const confirmMessage = `Bạn có chắc chắn muốn xóa "${attraction.title || id}"?\n\nHành động này không thể hoàn tác.`;
    
    if (confirm(confirmMessage)) {
        performDelete(id);
    }
}

// Get attraction data
function getAttractionData(id) {
    // Try to extract from DOM
    const card = findCardById(id);
    if (card) {
        const title = card.querySelector('.card-title, .featured-title')?.textContent?.trim() || 'Không có tên';
        const description = card.querySelector('.card-description, .featured-description')?.textContent?.trim() || '';
        const location = card.querySelector('.card-info-item span, .info-detail')?.textContent?.trim() || '';
        
        return { title, description, location };
    }
    
    return { title: id, description: '', location: '' };
}

// Find card by ID
function findCardById(id) {
    const buttons = document.querySelectorAll(`button[onclick*="${id}"]`);
    for (let button of buttons) {
        const card = button.closest('.attraction-card, .featured-card');
        if (card) return card;
    }
    return null;
}

// Show edit modal
function showEditModal(id, attraction) {
    console.log('🔧 Showing edit modal for:', id, attraction);
    
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.right = '0';
    modal.style.bottom = '0';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    modal.style.zIndex = '50';
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
    modal.style.padding = '1rem';
    
    modal.onclick = (e) => {
        if (e.target === modal) modal.remove();
    };
    
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.5rem; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto;">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0; font-size: 1.25rem; font-weight: bold;">Chỉnh Sửa Địa Điểm</h2>
                <button onclick="this.closest('.fixed').remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            
            <form style="padding: 1.5rem;" onsubmit="saveEdit(event, '${id}')">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tên Địa Điểm</label>
                    <input type="text" name="title" value="${attraction.title || ''}" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Mô Tả</label>
                    <textarea name="description" rows="4" 
                              style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">${attraction.description || ''}</textarea>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Địa Chỉ</label>
                    <input type="text" name="location" value="${attraction.location || ''}" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Lưu Thay Đổi
                    </button>
                    <button type="button" onclick="this.closest('.fixed').remove()" class="btn btn-secondary">
                        Hủy
                    </button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
}

// Save edit
function saveEdit(event, id) {
    event.preventDefault();
    console.log('🔧 Saving edit for:', id);
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    console.log('🔧 Form data:', data);
    
    // Update DOM if possible
    updateCardInDOM(id, data);
    
    // Close modal
    event.target.closest('.fixed').remove();
    
    showNotification('Đã cập nhật địa điểm thành công!', 'success');
}

// Update card in DOM
function updateCardInDOM(id, data) {
    const card = findCardById(id);
    if (!card) return;
    
    // Update title
    const titleEl = card.querySelector('.card-title, .featured-title');
    if (titleEl && data.title) {
        titleEl.textContent = data.title;
    }
    
    // Update description
    const descEl = card.querySelector('.card-description, .featured-description');
    if (descEl && data.description) {
        descEl.textContent = data.description;
    }
}

// Perform delete
function performDelete(id) {
    const card = findCardById(id);
    
    if (card) {
        // Animate out
        card.style.transition = 'all 0.5s ease';
        card.style.transform = 'scale(0.8)';
        card.style.opacity = '0';
        
        setTimeout(() => {
            card.remove();
            showNotification('Đã xóa địa điểm thành công!', 'success');
        }, 500);
    }
}

// Show notification
function showNotification(message, type = 'info') {
    console.log('🔧 Showing notification:', message, type);
    
    // Remove existing notification
    const existing = document.getElementById('admin-notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.id = 'admin-notification';
    notification.style.position = 'fixed';
    notification.style.top = '1rem';
    notification.style.right = '1rem';
    notification.style.zIndex = '60';
    notification.style.padding = '1rem 1.5rem';
    notification.style.borderRadius = '0.5rem';
    notification.style.color = 'white';
    notification.style.fontWeight = '600';
    notification.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.2)';
    notification.style.transform = 'translateX(100%)';
    notification.style.transition = 'transform 0.3s ease';
    
    switch (type) {
        case 'success':
            notification.style.background = '#10b981';
            break;
        case 'error':
            notification.style.background = '#ef4444';
            break;
        case 'warning':
            notification.style.background = '#f59e0b';
            break;
        default:
            notification.style.background = '#3b82f6';
    }
    
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Global functions for onclick handlers
function showAddAttractionForm() {
    console.log('🔧 Opening add attraction form...');
    window.open('quan-ly-dia-diem.html', '_blank');
}

function exportAttractions() {
    console.log('🔧 Exporting attractions...');
    showNotification('Chức năng xuất dữ liệu đang được phát triển', 'info');
}

// Make functions global
window.toggleAdminMode = toggleAdminMode;
window.editAttraction = editAttraction;
window.deleteAttraction = deleteAttraction;
window.showAddAttractionForm = showAddAttractionForm;
window.exportAttractions = exportAttractions;
window.saveEdit = saveEdit;

console.log('✅ Simple admin controls script loaded successfully!');