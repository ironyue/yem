document.addEventListener('DOMContentLoaded', () => {
    const filtros = document.querySelectorAll('.filtros button');
    const productos = document.querySelectorAll('.lista-productos .producto');

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
});
