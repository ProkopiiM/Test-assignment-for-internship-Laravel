/*


// Скрипты для email.blade.php
function showEmailErrors(errors) {
    errors.forEach(error => {
        alert(error);
    });
}

function showEmailStatus(status) {
    alert(status);
}

function redirectToLogin() {
    window.location.href = "/login";
}

// Скрипты для login.blade.php
function redirectToRegistration() {
    window.location.href = "/registration";
}

function formatPhoneInput(phoneInput) {
    phoneInput.addEventListener('input', function(event) {
        const input = event.target.value.replace(/\D/g, '').substring(0, 11);
        const phoneFormat = '+7 (' + input.substring(1, 4) + ') ' + input.substring(4, 7) + '-' + input.substring(7, 9) + '-' + input.substring(9, 11);
        event.target.value = phoneFormat;
    });
}

// Скрипты для create_order.blade.php
function showOrderError(error) {
    alert(error);
}

function toggleDeliveryBlock() {
    var select = document.getElementById('receiving');
    var deliveryBlock = document.getElementById('delivery-block');
    if (select.value == '1') {
        deliveryBlock.hidden = false;
    } else {
        deliveryBlock.hidden = true;
    }
}

function initCreateOrderScripts() {
    document.addEventListener('DOMContentLoaded', (event) => {
        toggleDeliveryBlock();
    });

    const phoneInput = document.getElementById('phone');
    formatPhoneInput(phoneInput);
}

// Скрипты для registration.blade.php
function showRegistrationError(error) {
    alert(error);
}

// Скрипты для category.blade.php и search.blade.php
function submitForm(formId) {
    document.getElementById(formId).submit();
}

function initViewToggle(viewId) {
    const view = localStorage.getItem('view');
    if (view === 'list') {
        setListView(viewId);
    } else {
        setGridView(viewId);
    }
}

function setGridView(viewId) {
    const container = document.getElementById(viewId);
    if (container)
    {
        container.classList.remove('list-view');
        container.classList.add('grid-view');
        localStorage.setItem('view', 'grid');
    }
    else {
        console.error(`Element with ID ${viewId} not found.`);
    }
}

function setListView(viewId) {
    const container = document.getElementById(viewId);
    if (container)
    {
        container.classList.remove('grid-view');
        container.classList.add('list-view');
        localStorage.setItem('view', 'list');
    }
    else {
        console.error(`Element with ID ${viewId} not found.`);
    }
}

// Скрипты для main.blade.php
function showPasswordChangeStatus(status) {
    if (status) {
        alert('Смена пароля прошла успешно');
    }
}

function initProductScroll() {
    document.querySelector('.prev-button').addEventListener('click', function() {
        document.getElementById('recommendProducts').scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    document.querySelector('.next-button').addEventListener('click', function() {
        document.getElementById('recommendProducts').scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });
}

function submitPaginateForm() {
    document.getElementById('paginate-form').submit();
}

// Вызовы функций в зависимости от страницы
document.addEventListener('DOMContentLoaded', (event) => {
    const bodyClass = document.body.className;

    if (bodyClass.includes('main-page')) {
        // Вызовы для main.blade.php
        if (window.pageData.status) {
            showPasswordChangeStatus(true);
        }
        initProductScroll();
    }

    if (bodyClass.includes('registration-page')) {
        // Вызовы для registration.blade.php
        if (window.pageData.error) {
            showRegistrationError(window.pageData.error);
        }
    }

    if (bodyClass.includes('create-order-page')) {
        // Вызовы для create_order.blade.php
        const phoneInput = document.getElementById('phone');
        formatPhoneInput(phoneInput);
        if (window.pageData.error) {
            showOrderError(window.pageData.error);
        }
        initCreateOrderScripts();
    }

    if (bodyClass.includes('email-page')) {
        // Вызовы для email.blade.php
        if (window.pageData.errors.length > 0) {
            showEmailErrors(window.pageData.errors);
        }
        if (window.pageData.status) {
            showEmailStatus(window.pageData.status);
        }
    }
    if (bodyClass.includes('product-page')) {
        // Вызовы для product.blade.php
        submitPaginateForm();
    }
    if (bodyClass.includes('category-page') || bodyClass.includes('search-page')) {
        // Вызовы для category.blade.php и search.blade.php
        initViewToggle('search-results');
    }
    if (bodyClass.includes('login-page')) {
        // Вызовы для login.blade.php
        redirectToRegistration();
        const phoneInput = document.getElementById('phone');
        formatPhoneInput(phoneInput);
    }
});
*/
