# RPG de Turnos CLI

Protótipo de jogo de combate 1 contra 1 executado no terminal com PHP. Dois jogadores escolhem uma classe e alternam turnos usando ataque básico, defesa ou ultimate até que um personagem seja derrotado.

## Requisitos

- PHP instalado e disponível no terminal.

Para verificar a instalação do PHP:

```bash
php -v
```

## Execução

No terminal, dentro da pasta do projeto (src), execute:

```bash
php index.php
```

O jogo vai pedir a escolha de classe do Jogador 1 e do Jogador 2. Depois disso, a batalha começa automaticamente.

## Ações de Combate

Em cada turno, o jogador atual pode escolher:

```text
1) Atacar
2) Defender
3) Usar Ult
```

- `Atacar`: causa dano baseado no ataque do personagem menos a defesa atual do alvo.
- `Defender`: adiciona bônus temporário de defesa até o próximo turno do próprio personagem.
- `Usar Ult`: executa a habilidade especial da classe e consome mana.

Todo personagem recupera mana no início do próprio turno.

## Classes

### Berserker

Passiva: **Fúria Crescente**

Quanto mais vida o Berserker perde, maior fica o dano causado. Para cada 2% de vida perdida, ele ganha 1% de dano adicional, até o máximo prático de 50%.

Ult: **Slash and Dash**

Causa dano alto ao alvo. A passiva também é aplicada ao dano da ult.

### Mage

Passiva: **Fluxo Arcano**

Ataques básicos recuperam 5 de mana.

Ult: **Chama Arcana**

Causa dano ao alvo e cura o Mago em 10 de vida.

### Necromancer

Passiva: **Colheita de Almas**

Sempre que causa dano, recupera 20% do dano causado como vida. Se causar 0 de dano, não recupera vida.

Ult: **Decomposição**

Causa dano ao alvo e também aplica a cura da passiva quando o dano é maior que 0.

### Monge

Passiva: **Serenidade**

Ataques básicos consecutivos aumentam o dano:

```text
1º ataque: dano normal
2º ataque: +20%
3º ataque: +40%
4º ataque em diante: +60%
```

Defender ou usar ult reinicia os acúmulos.

Ult: **Punho Suave**

Os próximos 3 ataques básicos recebem +10 de dano.

### Cavaleiro

Passiva: **Postura de Ferro**

Após defender, o próximo ataque básico causa dano adicional baseado na defesa atual.

Ult: **Armadura Pesada**

Aumenta a defesa em 20% por 2 turnos.

