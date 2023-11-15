// Obter elementos do DOM
const abrir = document.getElementById('abrir');
const fechar = document.getElementById('fechar');
const divFlutuante = document.getElementById('divFlutuante');

// Adicionar evento de clique para abrir a div flutuante
abrir.addEventListener('click', function() {
    divFlutuante.style.display = 'block';
});

// Adicionar evento de clique para fechar a div flutuante
fechar.addEventListener('click', function() {
    divFlutuante.style.display = 'none';
});
