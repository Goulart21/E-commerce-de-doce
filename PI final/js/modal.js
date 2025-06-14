// Função para alternar menu de perfil
function toggleProfileMenu() {
    document.getElementById('profileMenu').classList.toggle('show');
}

// Classe de Gerenciamento de Acessibilidade
class AccessibilityManager {
    constructor() {
        this.isDarkModeEnabled = false;
        this.isHighContrastMode = false;
        this.isTextReaderEnabled = false;
        this.baseFontSize = 1;
        this.speechSynthesis = window.speechSynthesis;
        this.textReadEventListener = null;
    }

    // Método para extrair texto de um elemento
    extractTextFromElement(element) {
        if (!element || element.closest('#accessibilityModal')) return '';

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = element.innerHTML;
        tempDiv.querySelectorAll('script, style').forEach(el => el.remove());

        return tempDiv.innerText.trim();
    }

    // Alternar Modo Escuro
    toggleDarkMode() {
        this.isDarkModeEnabled = !this.isDarkModeEnabled;
        
        if (this.isDarkModeEnabled) {
            document.body.classList.add('dark-mode');
            document.body.style.backgroundColor = '#333';
            document.body.style.color = '#fff';
            
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                card.style.backgroundColor = '#444';
                card.style.color = '#fff';
            });
        } else {
            document.body.classList.remove('dark-mode');
            document.body.style.backgroundColor = '';
            document.body.style.color = '';
            
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                card.style.backgroundColor = '';
                card.style.color = '';
            });
        }
        
        localStorage.setItem('darkMode', this.isDarkModeEnabled);
    }

    // Alternar Alto Contraste
    toggleHighContrast() {
        this.isHighContrastMode = !this.isHighContrastMode;
        
        if (this.isHighContrastMode) {
            document.body.classList.add('high-contrast');
            document.body.style.backgroundColor = '#000';
            document.body.style.color = '#fff';
            
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.style.color = '#ffff00';
            });
            
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.style.backgroundColor = '#fff';
                button.style.color = '#000';
                button.style.border = '2px solid #fff';
            });
        } else {
            document.body.classList.remove('high-contrast');
            document.body.style.backgroundColor = '';
            document.body.style.color = '';
            
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.style.color = '';
            });
            
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.style.backgroundColor = '';
                button.style.color = '';
                button.style.border = '';
            });
        }
        
        localStorage.setItem('highContrast', this.isHighContrastMode);
    }

    // Alternar Leitor de Texto
    toggleTextReader() {
        this.isTextReaderEnabled = !this.isTextReaderEnabled;
        
        if (this.isTextReaderEnabled) {
            this.startTextReading();
        } else {
            this.stopTextReading();
        }
    }

    // Iniciar Leitura de Texto
    startTextReading() {
        // Selecionar conteúdo principal, excluindo modal de acessibilidade
        const mainContent = document.querySelector('main') || document.body;
        const pageText = this.extractTextFromElement(mainContent);

        if (pageText) {
            this.speakText(pageText);
        }

        // Adicionar evento de hover para leitura de elementos específicos
        this.textReadEventListener = (event) => {
            if (!this.isTextReaderEnabled) return;

            const target = event.target;
            
            // Verificar se o elemento não está dentro do modal de acessibilidade
            if (!target.closest('#accessibilityModal')) {
                const text = this.extractTextFromElement(target);
                
                if (text) {
                    this.speakText(text);
                }
            }
        };
        
        // Adicionar evento de hover a todos os elementos, exceto o modal de acessibilidade
        document.body.addEventListener('mouseover', this.textReadEventListener);
    }

    // Falar Texto
    speakText(text) {
        // Parar qualquer fala em andamento
        this.stopTextReading();
        
        if (text) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'pt-BR';
            
            // Adicionar tratamento de erro
            utterance.onerror = (event) => {
                console.error('Erro na síntese de voz:', event);
            };

            this.speechSynthesis.speak(utterance);
        }
    }

    // Parar Leitura de Texto
    stopTextReading() {
        // Remover evento de hover
        if (this.textReadEventListener) {
            document.body.removeEventListener('mouseover', this.textReadEventListener);
        }
        
        // Cancelar qualquer fala em andamento
        if (this.speechSynthesis.speaking) {
            this.speechSynthesis.cancel();
        }
        
        this.isTextReaderEnabled = false;
    }

    // Aumentar Tamanho da Fonte
    increaseFontSize() {
        this.baseFontSize = Math.min(this.baseFontSize + 0.2, 2);
        document.body.style.fontSize = `${this.baseFontSize}em`;
    }

    // Diminuir Tamanho da Fonte
    decreaseFontSize() {
        this.baseFontSize = Math.max(this.baseFontSize - 0.2, 0.6);
        document.body.style.fontSize = `${this.baseFontSize}em`;
    }

    // Redefinir Configurações de Acessibilidade
    resetAccessibility() {
        // Parar leitura de texto
        this.stopTextReading();

        // Redefinir Modo Escuro
        if (this.isDarkModeEnabled) {
            this.toggleDarkMode();
        }

        // Redefinir Alto Contraste
        if (this.isHighContrastMode) {
            this.toggleHighContrast();
        }

        // Redefinir Tamanho da Fonte
        this.baseFontSize = 1;
        document.body.style.fontSize = '1em';

        // Fechar modal de acessibilidade
        this.toggleAccessibilityMenu();

        // Limpar armazenamento local
        localStorage.removeItem('darkMode');
        localStorage.removeItem('highContrast');
    }

    // Alternar Menu de Acessibilidade
    toggleAccessibilityMenu() {
        const modal = document.getElementById('accessibilityModal');
        const overlay = document.getElementById('accessibilityModalOverlay');
        
        modal.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // Inicializar Gerenciador de Acessibilidade
    init() {
        // Verificar preferências salvas
        const savedDarkMode = localStorage.getItem('darkMode') === 'true';
        const savedHighContrast = localStorage.getItem('highContrast') === 'true';

        if (savedDarkMode) this.toggleDarkMode();
        if (savedHighContrast) this.toggleHighContrast();

        // Adicionar evento de clique no overlay para fechar o modal
        const overlay = document.getElementById('accessibilityModalOverlay');
        overlay.addEventListener('click', () => {
            this.toggleAccessibilityMenu();
        });
    }
}

// Criar Instância do Gerenciador de Acessibilidade
const accessibilityManager = new AccessibilityManager();

// Eventos de DOM
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar configurações de acessibilidade
    accessibilityManager.init();

    // Alternar Menu de Acessibilidade
    document.querySelector('.accessibility-icon').addEventListener('click', () => {
        accessibilityManager.toggleAccessibilityMenu();
    });

    // Anexar eventos aos botões de acessibilidade
    document.getElementById('toggle-dark-mode').addEventListener('click', () => accessibilityManager.toggleDarkMode());
    
    document.getElementById('toggle-contrast').addEventListener('click', () => accessibilityManager.toggleHighContrast());
    
    document.getElementById('read-text').addEventListener('click', () => accessibilityManager.toggleTextReader());
    
    document.getElementById('increase-font').addEventListener('click', () => accessibilityManager.increaseFontSize());
    
    document.getElementById('decrease-font').addEventListener('click', () => accessibilityManager.decreaseFontSize());
    
    document.getElementById('reset-accessibility').addEventListener('click', () => accessibilityManager.resetAccessibility());
});