// Aircraft Liveries Database (static, no public editing)
const aircraftLiveries = [
    {
        name: "Airbus A320",
        type: "A320",
        registrations: "N-6001 to N-6010",
        quantity: "10 Aircraft",
        image: "✈️ A320"
    },
    {
        name: "Airbus A321",
        type: "A321",
        registrations: "N-7101 to N-7108",
        quantity: "8 Aircraft",
        image: "✈️ A321"
    }
];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadLiveries();
    setupAccountSystem();
    setupNavigation();
    checkSessionStatus();
});

// Load Liveries
function loadLiveries() {
    const container = document.getElementById('liveries-container');
    container.innerHTML = '';
    
    aircraftLiveries.forEach(livery => {
        const card = document.createElement('div');
        card.className = 'livery-card';
        card.innerHTML = `
            <div class="livery-image">${livery.image}</div>
            <div class="livery-info">
                <h3>${livery.name}</h3>
                <div class="livery-type">Type: ${livery.type}</div>
                <div class="livery-registrations">${livery.registrations}</div>
                <span class="livery-quantity">${livery.quantity}</span>
            </div>
        `;
        container.appendChild(card);
    });
}

// Account System Functions
function setupAccountSystem() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const applicationForm = document.getElementById('application-form');
    
    if (loginForm) {
        loginForm.addEventListener('submit', handleLoginSubmit);
    }
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegisterSubmit);
    }
    if (applicationForm) {
        applicationForm.addEventListener('submit', handleApplicationSubmit);
    }
}

function checkSessionStatus() {
    fetch('backend/session.php')
        .then(r => r.json())
        .then(data => {
            if (data.logged_in && data.pilot) {
                showPilotProfile(data.pilot);
            }
        })
        .catch(e => {});
}

function handleLoginSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('backend/login.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showPilotProfile(data.data);
            document.getElementById('login-form').reset();
            showMessage('Welcome back, ' + data.data.name + '!', 'success');
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(err => showMessage('Connection error', 'error'));
}

function handleRegisterSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('backend/register.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showPilotProfile(data.data);
            document.getElementById('register-form').reset();
            showMessage('Account created! Welcome to Apex Air, ' + data.data.name + '!', 'success');
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(err => showMessage('Connection error', 'error'));
}

function handleApplicationSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    const aircraftCheckboxes = document.querySelectorAll('input[name="aircraft"]:checked');
    formData.delete('aircraft');
    aircraftCheckboxes.forEach(cb => {
        formData.append('aircraft[]', cb.value);
    });
    
    fetch('backend/apply.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('application-form').reset();
            document.getElementById('apply').style.display = 'none';
            showMessage(data.message, 'success');
            checkSessionStatus();
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(err => showMessage('Connection error', 'error'));
}

function showPilotProfile(pilot) {
    document.getElementById('login-panel').classList.remove('active');
    document.getElementById('register-panel').classList.remove('active');
    document.getElementById('pilot-profile').style.display = 'block';
    
    document.getElementById('profile-name').textContent = pilot.name;
    document.getElementById('profile-vatsim').textContent = pilot.vatsim;
    document.getElementById('profile-status').textContent = capitalizeStatus(pilot.status);
    document.getElementById('profile-joined').textContent = new Date(pilot.created_at).toLocaleDateString();
    
    document.getElementById('pilot-id').value = pilot.id;
    document.getElementById('app-name').value = pilot.name;
    document.getElementById('app-email').value = pilot.email;
    document.getElementById('app-vatsim').value = pilot.vatsim;
    
    const applyBtn = document.querySelector('a[href="#apply"]');
    if (pilot.status === 'registered') {
        applyBtn.style.display = 'inline-block';
    } else {
        applyBtn.style.display = 'none';
    }
}

function capitalizeStatus(status) {
    return status.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
}

function logout() {
    if (confirm('Are you sure you want to logout?')) {
        fetch('backend/logout.php', { method: 'POST' })
            .then(() => {
                document.getElementById('pilot-profile').style.display = 'none';
                document.getElementById('login-panel').classList.add('active');
                document.getElementById('login-form').reset();
                document.getElementById('apply').style.display = 'none';
                showMessage('You have been logged out.', 'success');
            });
    }
}

function switchAuth(e, panel) {
    e.preventDefault();
    
    document.getElementById('login-panel').classList.remove('active');
    document.getElementById('register-panel').classList.remove('active');
    
    if (panel === 'login') {
        document.getElementById('login-panel').classList.add('active');
    } else {
        document.getElementById('register-panel').classList.add('active');
    }
}

function cancelApplication() {
    document.getElementById('apply').style.display = 'none';
}

function showMessage(message, type) {
    const msg = document.createElement('div');
    msg.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 4px;
        color: white;
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
        max-width: 400px;
    `;
    
    if (type === 'success') {
        msg.style.backgroundColor = '#55efc4';
        msg.style.color = '#00b894';
    } else {
        msg.style.backgroundColor = '#fab1a0';
        msg.style.color = '#d63031';
    }
    
    msg.textContent = message;
    document.body.appendChild(msg);
    
    setTimeout(() => msg.remove(), 4000);
}

// Navigation setup
function setupNavigation() {
    const navLinks = document.querySelectorAll('.nav-links a, a[href="#apply"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#apply') {
                const profilePanel = document.getElementById('pilot-profile');
                if (profilePanel.style.display !== 'none') {
                    const applySection = document.getElementById('apply');
                    applySection.style.display = 'block';
                    applySection.scrollIntoView({ behavior: 'smooth' });
                    e.preventDefault();
                } else {
                    alert('Please login first to apply!');
                    e.preventDefault();
                    document.querySelector('a[href="#accounts"]').click();
                }
            }
            
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    window.addEventListener('scroll', function() {
        let current = '';
        const sections = document.querySelectorAll('section');
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(current)) {
                link.classList.add('active');
            }
        });
    });
}

// Contact form submission
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const inputs = this.querySelectorAll('input, textarea');
        
        let isValid = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderBottom = '2px solid #ff4444';
            } else {
                input.style.borderBottom = '2px solid #44ff44';
            }
        });

        if (isValid) {
            const originalHTML = this.innerHTML;
            this.innerHTML = `
                <div style="text-align: center; padding: 2rem; background: rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                    <h3 style="margin-bottom: 1rem;">Thank you for your interest!</h3>
                    <p>We've received your message and will get back to you soon.</p>
                    <button type="button" class="btn btn-secondary" style="margin-top: 1rem;">Reset Form</button>
                </div>
            `;
            
            const resetBtn = this.querySelector('button');
            resetBtn.addEventListener('click', function() {
                contactForm.innerHTML = originalHTML;
                contactForm.addEventListener('submit', arguments.callee);
            });
        }
    });
}

// Scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
        }
    });
}, observerOptions);

document.querySelectorAll('.about-card, .livery-card, .pilot-stat, .auth-panel').forEach(card => {
    observer.observe(card);
});

// Add animation keyframes dynamically
const style = document.createElement('style');
style.innerHTML = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);

// Add scroll animation to hero on load
window.addEventListener('load', function() {
    const hero = document.querySelector('.hero-content');
    if (hero) {
        hero.style.animation = 'slideIn 0.8s ease-out';
    }
});
