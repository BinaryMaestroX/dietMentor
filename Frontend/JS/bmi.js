function calculate() {
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;

    if (weight && height) {
        const meters = height / 100;
        const bmi = weight / (meters * meters);
        const maintenanceCalories = (10 * weight) + (6.25 * height) - 5 * 25 + 5;

        const form = document.getElementById('calorie-form');
        form.innerHTML = `<label>BMI:</label><input type="text" value="${bmi.toFixed(2)}" readonly>`;

        let dietId;
        if (bmi < 18.5) {
            dietId = 1;
        } else if (bmi >= 18.5 && bmi < 25) {
            dietId = 2;
        } else if (bmi >= 25 && bmi < 30) {
            dietId = 3;
        } else if (bmi >= 30 && bmi < 35) {
            dietId = 4;
        } else if (bmi >= 35 && bmi < 40) {
            dietId = 5;
        } else if (bmi >= 40) {
            dietId = 6;
        }

        const result = document.getElementById('result');
        result.innerHTML = `
            Your maintenance calories are approximately ${maintenanceCalories.toFixed(2)} kcal/day.
            <br>
            <button data-diet_id="${dietId}" onclick="fetchDiet(${dietId})">View Suggested Diet</button>
        `;
    } else {
        alert('Please enter both weight and height.');
    }
}

function fetchDiet(dietId) {
    $.ajax({
        url: 'https://dietmentor.000webhostapp.com/Backend/API/Diet.php',
        type: 'POST',
        data: { diet_id: dietId },
        success: function(response) {
            if (response.status === 'success') {
                const diet = response.data;
                alert(`Diet Name: ${diet.diet_name}\nDescription: ${diet.description}`);
            } else {
                alert(`Error: ${response.message}`);
            }
        },
        error: function(error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the diet.');
        }
    });
}



