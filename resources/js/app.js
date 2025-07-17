document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('toggleTipoValor');
    const label = document.getElementById('valueLabel');

    function updateLabel() {
      label.textContent = checkbox.checked ? 'Valor de Compra' : 'Valor de Venda';
    }

    checkbox.addEventListener('change', updateLabel);
    updateLabel(); // Chamada inicial para refletir o estado salvo (ex: após F5)
  });
