document.addEventListener('DOMContentLoaded', () => {
    const filtros = document.querySelectorAll('.filtros button');
    const productos = document.querySelectorAll('.lista-productos .producto');
    const carritoContainer = document.querySelector('.lista-carrito');
    const subtotalEl = document.getElementById('subtotal');
    const costoEnvioEl = document.getElementById('costo-envio');
    const totalEl = document.getElementById('total');
    const procederPagoBtn = document.getElementById('proceder-pago');
    const calcularEnvioBtn = document.getElementById('calcular-envio');
    const codigoPostalInput = document.getElementById('codigo-postal');

    filtros.forEach(filtro => {
        filtro.addEventListener('click', () => {
            const categoria = filtro.getAttribute('data-categoria');
            productos.forEach(producto => {
                if (categoria === 'todos' || producto.getAttribute('data-categoria') === categoria) {
                    producto.style.display = 'block';
                } else {
                    producto.style.display = 'none';
                }
            });
        });
    });

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', (e) => {
            const productId = e.target.getAttribute('data-id');
            addToCart(productId);
        });
    });

    function addToCart(id) {
        fetch('agregar_al_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderCarrito();
            } else {
                alert('Error al agregar producto al carrito.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al agregar producto al carrito.');
        });
    }

    function renderCarrito() {
        fetch('obtener_carrito.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                carritoContainer.innerHTML = '';
                let subtotal = 0;

                data.carrito.forEach(product => {
                    const totalPrecio = product.precio * product.cantidad;
                    subtotal += totalPrecio;

                    const productEl = document.createElement('div');
                    productEl.classList.add('producto-carrito');
                    productEl.innerHTML = `
                        <img src="img/${product.pid}.jpg" alt="${product.nombre}">
                        <div class="detalles-producto">
                            <h3>${product.nombre}</h3>
                            <p>Cantidad: ${product.cantidad}</p>
                            <p>Precio: $${totalPrecio.toFixed(2)}</p>
                            <button class="remove-from-cart" data-id="${product.cid}">Eliminar</button>
                        </div>
                    `;
                    carritoContainer.appendChild(productEl);

                    productEl.querySelector('.remove-from-cart').addEventListener('click', (e) => {
                        removeFromCart(e.target.getAttribute('data-id'));
                    });
                });

                subtotalEl.textContent = subtotal.toFixed(2);
                costoEnvioEl.textContent = "0.00";
                totalEl.textContent = subtotal.toFixed(2);
            } else {
                alert('Error al obtener el carrito.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener el carrito.');
        });
    }

    function removeFromCart(id) {
        fetch('eliminar_del_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderCarrito();
            } else {
                alert('Error al eliminar producto del carrito.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar producto del carrito.');
        });
    }

    calcularEnvioBtn.addEventListener('click', () => {
        const codigoPostal = codigoPostalInput.value;
        calcularEnvio(codigoPostal);
    });

    function calcularEnvio(codigoPostal) {
        fetch(`calcular_envio.php?codigo_postal=${codigoPostal}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const costoEnvio = data.costoEnvio;
                const subtotal = parseFloat(subtotalEl.textContent);
                const total = subtotal + costoEnvio;
                costoEnvioEl.textContent = costoEnvio.toFixed(2);
                totalEl.textContent = total.toFixed(2);
            } else {
                alert('Error al calcular el costo de envío.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al calcular el costo de envío.');
        });
    }

    procederPagoBtn.addEventListener('click', () => {
        alert('Funcionalidad de pago no implementada aún.');
    });

    // Cargar el carrito al cargar la página
    renderCarrito();
});
