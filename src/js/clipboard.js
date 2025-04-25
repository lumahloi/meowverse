document.getElementById('copiar').addEventListener('click', function() {
    const chave = '3ea77c7a-f0f9-4d2d-a859-0b259bf6a2c2';

    // Criar um elemento de texto temporário
    const textareaTemp = document.createElement('textarea');
    textareaTemp.value = chave;

    // Adicionar o elemento de texto temporário ao corpo do documento
    document.body.appendChild(textareaTemp);

    // Selecionar e copiar o texto
    textareaTemp.select();
    document.execCommand('copy');

    // Remover o elemento de texto temporário
    document.body.removeChild(textareaTemp);
});