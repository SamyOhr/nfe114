// Génère des données aléatoires
function generateRandomData() {
    const data = [];
    for (let i = 0; i < 10; i++) {
        data.push(Math.floor(Math.random() * 100));
    }
    return data;
}

// Crée le graphique avec Chart.js
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct'],
        datasets: [{
            label: 'Données aléatoires',
            data: generateRandomData(),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
