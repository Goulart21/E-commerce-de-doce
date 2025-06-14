document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orderForm');
    
    if (!form) {
        console.error('Formulário não encontrado');
        return;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const orderData = Object.fromEntries(formData.entries());
        
        // Format WhatsApp message
        const message = `🛒 *Novo Pedido - Bão D'oce*\n\n` +
            `*Cliente:* ${orderData.name}\n` +
            `*Telefone:* ${orderData.number}\n` +
            `*Endereço:* ${orderData.address}\n` +
            `*CPF:* ${orderData.cpf}\n` +
            `*Forma de Pagamento:* ${orderData.payment}\n` +
            `*Cupom:* ${orderData.coupon || 'Não utilizado'}\n\n` +
            `*Itens do Pedido:*\n${orderData.items.replace(/, /g, '\n')}\n\n` +
            `*Total:* R$ ${parseFloat(orderData.total).toFixed(2).replace('.', ',')}`;

        // Save to database first
        fetch('process_order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Primeiro abre o WhatsApp
                const whatsappURL = `https://wa.me/5531989116569?text=${encodeURIComponent(message)}`;
                const whatsappWindow = window.open(whatsappURL, '_blank');
                
                // Depois de um pequeno delay, redireciona
                setTimeout(() => {
                    window.location.href = 'card.php';
                }, 1000);
            } else {
                alert('Erro ao processar pedido. Tente novamente.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar pedido. Tente novamente.');
        });
    });
});