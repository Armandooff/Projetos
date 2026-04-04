import pygame

# Configurações da janela
LarguraJanela = 640
AlturaJanela = 480

# Variáveis do jogo
xDaBola = 0
yDaBola = 0
TamanhoDaBola = 20
VelocidadeDaBolaEmX = 3
VelocidadeDaBolaEmY = 3

yDoJogador1 = 0
yDoJogador2 = 0

 # Pontuação
score_a = 0
score_b = 0

# Funções relacionadas aos jogadores
def xDoJogador1():
    return -LarguraJanela / 2 + LarguraDosJogadores() / 2

def xDoJogador2():
    return LarguraJanela / 2 - LarguraDosJogadores() / 2

def LarguraDosJogadores():
    return TamanhoDaBola

def AlturaDosJogadores():
    return 3 * TamanhoDaBola

def atualizar():
    global xDaBola, yDaBola, VelocidadeDaBolaEmX, VelocidadeDaBolaEmY, yDoJogador1, yDoJogador2, score_a, score_b

    xDaBola += VelocidadeDaBolaEmX
    yDaBola += VelocidadeDaBolaEmY

    # Colisão com os jogadores
    if (xDaBola + TamanhoDaBola / 2 > xDoJogador2() - LarguraDosJogadores() / 2
        and yDaBola - TamanhoDaBola / 2 < yDoJogador2 + AlturaDosJogadores() / 2 
        and yDaBola + TamanhoDaBola / 2 > yDoJogador2 - AlturaDosJogadores() / 2):
        VelocidadeDaBolaEmX = -VelocidadeDaBolaEmX

    if (xDaBola - TamanhoDaBola / 2 < xDoJogador1() + LarguraDosJogadores() / 2
        and yDaBola - TamanhoDaBola / 2 < yDoJogador1 + AlturaDosJogadores() / 2
        and yDaBola + TamanhoDaBola / 2 > yDoJogador1 - AlturaDosJogadores() / 2):
        VelocidadeDaBolaEmX = -VelocidadeDaBolaEmX

    # Colisão com as bordas da janela
    if yDaBola + TamanhoDaBola / 2 > AlturaJanela / 2 or yDaBola - TamanhoDaBola / 2 < -AlturaJanela / 2:
        VelocidadeDaBolaEmY = -VelocidadeDaBolaEmY

    # Pontuação
    if xDaBola > LarguraJanela / 2:
        score_a += 1
        xDaBola, yDaBola = 0, 0  # Reseta a posição da bola
        VelocidadeDaBolaEmX = -VelocidadeDaBolaEmX

    if xDaBola < -LarguraJanela / 2:
        score_b += 1
        xDaBola, yDaBola = 0, 0  # Reseta a posição da bola
        VelocidadeDaBolaEmX = -VelocidadeDaBolaEmX

    # Movimentação dos jogadores
    keys = pygame.key.get_pressed()

    # Jogador 1 (limita movimento para não sair da tela)
    if keys[pygame.K_s] and yDoJogador1 + AlturaDosJogadores() / 2 < AlturaJanela / 2:
        yDoJogador1 += 5
    if keys[pygame.K_w] and yDoJogador1 - AlturaDosJogadores() / 2 > -AlturaJanela / 2:
        yDoJogador1 -= 5

    # Jogador 2 (limita movimento para não sair da tela)
    if keys[pygame.K_DOWN] and yDoJogador2 + AlturaDosJogadores() / 2 < AlturaJanela / 2:
        yDoJogador2 += 5
    if keys[pygame.K_UP] and yDoJogador2 - AlturaDosJogadores() / 2 > -AlturaJanela / 2:
        yDoJogador2 -= 5

# Função para desenhar o retângulo
def DesenharRetangulo(screen, x, y, largura, altura, cor):
    pygame.draw.rect(screen, cor, pygame.Rect(x - largura // 2, y - altura // 2, largura, altura))

# Função para desenhar o placar
def desenhar_placar(screen):
    font = pygame.font.SysFont('New work times', 30)
    score_text = font.render(f"Jogador A: {score_a}  Jogador B: {score_b}", True, (255, 255, 255))
    screen.blit(score_text, (LarguraJanela // 2 - score_text.get_width() // 2, 10))

# Função para desenhar a linha pontilhada
def DesenharLinhaPontilhada(screen):
    largura_linha = 5
    altura_linha = 20
    espaco_entre_pontos = 15
    for y in range(-AlturaJanela // 2, AlturaJanela // 2, altura_linha + espaco_entre_pontos):
        DesenharRetangulo(screen, LarguraJanela // 2, y + AlturaJanela // 2, largura_linha, altura_linha, (255, 255, 255))

# Função de renderização
def desenhar(screen):
    screen.fill((0, 0, 0))  # Limpa a tela com preto

    DesenharLinhaPontilhada(screen)
    DesenharRetangulo(screen, xDaBola + LarguraJanela // 2, yDaBola + AlturaJanela // 2, TamanhoDaBola, TamanhoDaBola, (255, 255, 255))  # Bola
    DesenharRetangulo(screen, xDoJogador1() + LarguraJanela // 2, yDoJogador1 + AlturaJanela // 2, LarguraDosJogadores(), AlturaDosJogadores(), (255, 255, 255)) # Jogador 1
    DesenharRetangulo(screen, xDoJogador2() + LarguraJanela // 2, yDoJogador2 + AlturaJanela // 2, LarguraDosJogadores(), AlturaDosJogadores(), (255, 255, 255)) # Jogador 2

    # Desenha o placar
    desenhar_placar(screen)

# Inicialização do pygame
pygame.init()
screen = pygame.display.set_mode((LarguraJanela, AlturaJanela))
clock = pygame.time.Clock()

# Loop principal do jogo
while True:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.quit()
            exit()

    atualizar()
    desenhar(screen)
    pygame.display.flip()
    clock.tick(60)

# NOSSO JOGO EM PYTHON !!!