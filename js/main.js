// Load component function
function loadComponent(url, containerId) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById(containerId).innerHTML = data;
        })
        .catch(error => console.error('Error loading component:', error));
}

// Update current date time
function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    const dateTimeString = now.toLocaleDateString('vi-VN', options);
    const dateTimeElement = document.getElementById('currentDateTime');
    if (dateTimeElement) {
        dateTimeElement.textContent = dateTimeString;
    }
}

// Toggle content function
function toggleContent() {
    const content = document.getElementById('content');
    if (content) {
        content.classList.toggle('hidden');
        if (!content.classList.contains('hidden')) {
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
        }
    }
}

// Search function
function handleSearch() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.di-tich-card-item');
    
    cards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const address = card.querySelector('.di-tich-address');
        const addressText = address ? address.textContent.toLowerCase() : '';
        
        if (title.includes(query) || addressText.includes(query)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Toggle details function
function toggleDetails(detailsId, iconId) {
    const details = document.getElementById(detailsId);
    const icon = document.getElementById(iconId);
    
    if (details) {
        details.classList.toggle('hidden');
    }
    
    if (icon) {
        icon.classList.toggle('rotate-180');
    }

    // Close booking forms and admin panels when collapsing details
    if (details && details.classList.contains('hidden')) {
        const diTichId = detailsId.replace('-details', '');
        const bookingForm = document.getElementById(`bookingForm-${diTichId}`);
        const adminPanel = document.getElementById(`adminPanel-${diTichId}`);
        if (bookingForm) bookingForm.classList.add('hidden');
        if (adminPanel) adminPanel.classList.add('hidden');
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute
});