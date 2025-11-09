class TextTyper {
            constructor(elementId, options = {}) {
                this.element = document.getElementById(elementId);
                this.text = options.text || 'Hello World!';
                this.speed = options.speed || 100;
                this.showCursor = options.showCursor !== false;
                
                this.currentCharIndex = 0;
            }

            type() {
                if (this.currentCharIndex < this.text.length) {
                    this.element.textContent += this.text.charAt(this.currentCharIndex);
                    this.currentCharIndex++;
                    setTimeout(() => this.type(), this.speed);
                }
            }

            start() {
                this.type();
            }
        }
        const typer = new TextTyper('typing-text', {
            text: 'Discover, Register, and Join Campus Events Effortlessly...',
            speed: 80,
            showCursor: true
        });

        typer.start();

