


const form = document.getElementById('contact-form');

form.addEventListener('submit', function (event) {
  event.preventDefault(); // Stop the form from submitting

  if (validateForm()) {
    form.submit(); // Would actually submit when PHP is ready
  }
});


function validateForm() {
  let isValid = true;
  clearErrors();

  // Name validation
  const name = document.getElementById('name');
  if (name.value.trim().length < 2) {
    showError(name, 'Name must be at least 2 characters');
    isValid = false;
  }

  // Email validation
  const email = document.getElementById('email');
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email.value)) {
    showError(email, 'Please enter a valid email address');
    isValid = false;
  }

  // Phone validation (optional field)
  const phone = document.getElementById('phone');
  if (phone.value && !/^[0-9]{11}$/.test(phone.value)) {
    showError(phone, 'Phone must be 11 digits');
    isValid = false;
  }

  // Message validation
  const message = document.getElementById('message');
  if (message.value.trim().length < 10) {
    showError(message, 'Message must be at least 10 characters');
    isValid = false;
  }

  return isValid;
}

//real-time validation for name field
document.getElementById('name').addEventListener('input', function () {
  const errorSpan = this.parentElement.querySelector('.error-message');

  if (this.value && this.value.trim().length < 2) {
    showError(this, 'Name must be at least 2 characters');
  } else {
    errorSpan.textContent = '';
    errorSpan.classList.remove('visible');
    this.classList.remove('invalid');
  }
});

//real-time validation for email field
document.getElementById('email').addEventListener('input', function () {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const errorSpan = this.parentElement.querySelector('.error-message');

  if (this.value && !emailPattern.test(this.value)) {
    showError(this, 'Please enter a valid email address');
  } else {
    errorSpan.textContent = '';
    errorSpan.classList.remove('visible');
    this.classList.remove('invalid');
  }
});

//real-time validation for phone field
document.getElementById('phone').addEventListener('input', function () {
  const phonePattern = /^[0-9]{11}$/;
  const errorSpan = this.parentElement.querySelector('.error-message');

  if (this.value && !phonePattern.test(this.value)) {
    showError(this, 'Phone must be 11 digits');
  } else {
    errorSpan.textContent = '';
    errorSpan.classList.remove('visible');
    this.classList.remove('invalid');
  }
})

//real-time validation for message field
document.getElementById('message').addEventListener('input', function () {
  const errorSpan = this.parentElement.querySelector('.error-message');

  if (this.value && this.value.trim().length < 10) {
    showError(this, 'Message must be at least 10 characters');
  } else {
    errorSpan.textContent = '';
    errorSpan.classList.remove('visible');
    this.classList.remove('invalid');
  }
})



function showError(input, message) {
  const errorSpan = input.parentElement.querySelector('.error-message');
  errorSpan.textContent = message;
  errorSpan.classList.add('visible');
  input.classList.add('invalid');
}

function clearErrors() {
  document.querySelectorAll('.error-message').forEach(span => {
    span.textContent = '';
    span.classList.remove('visible');
  });
  document.querySelectorAll('.invalid').forEach(input => {
    input.classList.remove('invalid');
  });
}
