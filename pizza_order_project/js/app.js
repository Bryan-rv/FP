// Mostrar y ocultar el loader
function showLoader() {
    document.getElementById('loader').style.display = 'block';
}

function hideLoader() {
    document.getElementById('loader').style.display = 'none';
}

// Añadir una nueva orden
document.getElementById('orderForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    showLoader();
    let pizza = document.getElementById('pizza').value;
    let quantity = document.getElementById('quantity').value;
    let drink = document.getElementById('drink').value;
    let side = document.getElementById('side').value;
    let dessert = document.getElementById('dessert').value;
    let tableNumber = document.getElementById('tableNumber').value;
    let takeaway = document.getElementById('takeaway').checked ? 1 : 0;

    let orderData = {
        pizza: pizza,
        quantity: quantity,
        drink: drink,
        side: side,
        dessert: dessert,
        tableNumber: tableNumber,
        takeaway: takeaway
    };

    fetch('api/orders.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        alert('Orden agregada exitosamente! ID de la Orden: ' + data.orderId);
        window.location.href = 'index.html';
    })
    .catch(error => console.error('Error:', error))
    .finally(() => hideLoader());
});

// Completar una orden
document.getElementById('paymentForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    showLoader();
    let orderId = document.getElementById('orderId').value;

    fetch(`api/orders.php?orderId=${orderId}`, {
        method: 'PUT'
    })
    .then(response => response.json())
    .then(data => {
        alert('Orden completada exitosamente!');
        window.location.href = 'index.html';
    })
    .catch(error => console.error('Error:', error))
    .finally(() => hideLoader());
});

// Obtener el resumen de órdenes
if (document.getElementById('orderSummary')) {
    showLoader();
    fetch('api/orders.php')
    .then(response => response.json())
    .then(data => {
        let summary = '';
        data.forEach(order => {
            summary += `<p>Orden ID: ${order.id}, Pizza: ${order.pizza}, Cantidad: ${order.quantity}, Estado: ${order.completed ? 'Completada' : 'Pendiente'}</p>`;
        });
        document.getElementById('orderSummary').innerHTML = summary;
    })
    .catch(error => console.error('Error:', error))
    .finally(() => hideLoader());
}
