// Minimal Auth JavaScript - Safe for Laravel
// Only UX features, no form interference

document.addEventListener("DOMContentLoaded", () => {
    console.log("🔐 Auth page loaded!");

    // ==================== PASSWORD VISIBILITY TOGGLE ====================
    const togglePasswordButtons = document.querySelectorAll(".toggle-password");

    togglePasswordButtons.forEach(button => {
        button.addEventListener("click", function() {
            const targetId = this.getAttribute("data-target");
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        });
    });

    // ==================== PASSWORD STRENGTH INDICATOR ====================
    const passwordInput = document.getElementById("password");
    const strengthFill = document.querySelector(".strength-fill");
    const strengthText = document.querySelector(".strength-text");

    if (passwordInput && strengthFill) {
        passwordInput.addEventListener("input", function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);

            strengthFill.className = "strength-fill";

            if (strength.score === 0) {
                strengthFill.style.width = "0";
                strengthText.textContent = "Password strength";
                strengthText.style.color = "#64748b";
            } else if (strength.score <= 2) {
                strengthFill.classList.add("weak");
                strengthText.textContent = "Weak";
                strengthText.style.color = "#ef4444";
            } else if (strength.score <= 3) {
                strengthFill.classList.add("medium");
                strengthText.textContent = "Medium";
                strengthText.style.color = "#f59e0b";
            } else {
                strengthFill.classList.add("strong");
                strengthText.textContent = "Strong";
                strengthText.style.color = "#10b981";
            }
        });
    }

    function calculatePasswordStrength(password) {
        let score = 0;

        if (!password) return { score: 0 };

        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^a-zA-Z0-9]/.test(password)) score++;

        return { score: Math.min(score, 5) };
    }

    // ==================== CLEAR VALIDATION ERRORS ON INPUT ====================
    const formInputs = document.querySelectorAll(".form-control");

    formInputs.forEach(input => {
        input.addEventListener("input", function() {
            // Remove Laravel error styling when user starts typing
            this.classList.remove("is-invalid");

            // Hide error message
            const errorMsg = this.parentElement.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains("invalid-feedback")) {
                errorMsg.style.display = "none";
            }
        });
    });

    console.log("✨ Auth UX loaded!");
});
