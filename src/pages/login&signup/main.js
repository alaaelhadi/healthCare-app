const loginBtn = document.querySelector(".login-btn");
const signupBtn = document.querySelector(".signup-btn");
const loginForm = document.querySelector(".login-form");
const signupForm = document.querySelector(".signup-form");
const jobFunction = document.querySelector(".job-function");
const jobRole = document.querySelector(".job-role");
const otherInputFunc = document.querySelector(".other-input-function");
const otherInputRole = document.querySelector(".other-input-role");
const inputElements = document.getElementsByTagName("input");
const selectElement = document.querySelectorAll(".form-select");
const countrySelect = document.getElementById("country");
const signupLink = document.querySelector(".signup-link");
const firstNameInput = document.getElementById('signup-firstname');
const lastNameInput = document.getElementById('signup-lastname');
const emailInput = document.getElementById('signup-email');
const numberInput = document.getElementById('signup-number')
const passwordInput = document.getElementById('signup-password');
const companyNameInput = document.getElementById('signup-company');


// TOGGLE LOGIN & SIGNUP FORMS
const toggleLogin = () => {
    loginBtn.addEventListener("click", (event) => {
        event.preventDefault(); 
        loginForm.style.display = "block";
        signupForm.style.display = "none"; 
    });

    signupBtn.addEventListener("click", (event) => {
        event.preventDefault(); 
        signupForm.style.display = "block";
        loginForm.style.display = "none"; 
    });
}

toggleLogin();

// SIGNUP LINK
signupLink.addEventListener("click", (event) => {
    event.preventDefault(); 
    signupForm.style.display = "block";
    loginForm.style.display = "none";
});

// OTHER INPUT FIELD
// const otherOptionFunction = () => {
//         if(jobFunction.value === "other") {
//             otherInputFunc.style.display = "block";
//         } else {
//             otherInputFunc.style.display = "none";
//         }
//         if(jobRole.value === "other") {
//             otherInputRole.style.display = "block";
//         } else {
//             otherInputRole.style.display = "none";
//         }
// }

// window.addEventListener('load', otherOptionFunction);

// jobFunction.addEventListener("change", otherOptionFunction);

// COUNTRIES DROPDOWN API
document.addEventListener("DOMContentLoaded", ()=> {
    async function fetchData() {
        try {
          const response = await fetch('https://countriesnow.space/api/v0.1/countries/positions'); 
          if (response.ok) {
            const data = await response.json();
            let result = '';
            data.data.forEach((country) => {
                result += `<option>${country.name}</option>`
            })
            countrySelect.innerHTML += result;

          } else {
            console.error(response.status);
          }
        } catch (error) {
          console.error(error);
        }
      }
    
      fetchData();
})

// // FORM VALIDATION
// // const forms = document.querySelectorAll(".needs-validation");

// // forms.forEach((form) => {
// //   form.addEventListener('submit', (e) => {
// //     if (!form.checkValidity()) {
// //       e.preventDefault();
// //     } 
// //     form.classList.add('was-validated'); 
// //     console.log("Form validation")
// //   },
// //   false
// // );
// // });

 
// VALIDATION
// signupForm.addEventListener('submit', (event) => {
//     // event.preventDefault();
//     let isValid = true;

//         if (firstNameInput.value.trim() === '' || firstNameInput.value.trim().length < 3) {
//             displayError(firstNameInput, 'Please enter a valid first name!');
//             isValid = false;
//         } else {
//             hideError(firstNameInput);
//         }

//         if (lastNameInput.value.trim() === '' || lastNameInput.value.length < 3) {
//             displayError(lastNameInput, 'Please enter a valid last name!');
//             isValid = false;
//         } else {
//             hideError(lastNameInput);
//         }

//         if (!emailIsValid(emailInput.value)) {
//             displayError(emailInput, 'Please enter a valid email!');
//             isValid = false;
//         } else {
//             hideError(emailInput);
//         }

//         if (numberInput.value === '' || numberInput.value.length < 11){
//             displayError(numberInput, 'Please enter a valid mobile number!');
//             isValid = false;
//         } else {
//             hideError(numberInput);
//         }
    
//         if (passwordInput.value === '' || passwordInput.value.length < 8) {
//             displayError(passwordInput, 'Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.');
//             isValid = false;
//         } else {
//             hideError(passwordInput);
//         }

//         if (countrySelect.value === 'Country*') {
//             displayError(countrySelect, 'Please select a country!');
//             isValid = false;
//         } else {
//             hideError(countrySelect);
//         }

//         if (companyNameInput.value === '') {
//             displayError(companyNameInput, 'Please enter your workplace!');
//             isValid = false;
//         } else {
//             hideError(companyNameInput);
//         }

//     // FORM SUBMISSION
//     if (isValid) {
//         let xhr = new XMLHttpRequest();
//         xhr.open('POST', 'index.php', true);
//         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//         xhr.onload = function() {
//             if (xhr.status === 200) {
//                 console.log("Form submitted");
//             } else {
//                 console.error("Error submitting form");
//             }
//         };

//         let formData = new FormData(signupForm);
//         let encodedData = new URLSearchParams(formData).toString();
//         console.log(encodedData);
//         xhr.send(encodedData); 
//         // signupForm.submit();
//     }
//     else {
        
//         console.log("Form is not submitted");
//     }
// })
// // REGEX EMAIL VALIDATION
// function emailIsValid(email) {
//     return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
// }

// // ERROR MESSAGE DISPLAY
// function displayError(element, message) {
//     const errorParent = element.closest('.input-parent');
//     const errorMsg = errorParent.querySelector('.error');

//     errorMsg.style.display = 'block';
//     errorMsg.textContent = message;
//     element.classList.add('is-invalid');
// }

// // SUCCESS MESSAGE DISPLAY
// function hideError(element) {
//     const successParent = element.closest('.input-parent');
//     const successMsg = successParent.querySelector('.success');
//     const errorParent = element.closest('.input-parent');
//     const errorMsg = errorParent.querySelector('.error');

//     successMsg.textContent = '';
//     successMsg.style.display = 'block';
//     errorMsg.style.display = 'none';
//     element.classList.remove('is-invalid');
// }





// CLEARING INPUTS ON REFRESH
// function clearInput() {
//     for (let i = 0; i < inputElements.length; i++) {
//         if (inputElements[i].type === 'submit') {
//             continue;
//         } else {
//             inputElements[i].value = "";
//         }
//     }

//     selectElement.forEach(element => {
//         element.selectedIndex = 0;
//     });
// }

// window.addEventListener('load', clearInput);

