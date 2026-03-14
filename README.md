# clube-de-leitura-dev
Repositório do projeto Clube de Leitura (setup mínimo).

Uso rápido
- Requisitos: Docker (em modo Linux containers) e Shell (Git Bash ou PowerShell).
- Executar um arquivo PHP dentro do container:

```bash
./build php /app/index.php        # se index.php estiver na raiz do projeto
./build php app/index.php        # se o projeto usar a pasta `app`
```

Notas sobre Windows/Git Bash
- O script `build` já trata a conversão de caminhos no Git Bash/MSYS e usa `--mount` + `--workdir`.
- Se houver problemas com mounts, rode em PowerShell ou ative "Switch to Linux containers" no Docker Desktop.

Sugestões
- Para executar sempre dentro da pasta `app`, mova os arquivos para `app/` ou deixe como está — o `build` detecta automaticamente.

Notas do livro
- Capítulo I - ORIENTAÇÃO A OBJETOS,  PARA QUE TE QUERO?
> "sabendo o que são classes, a usar o mecanismo de herança e viram
exemplos de Cachorro, Gato e Papagaio para entender
polimorfismo"

> "procedural disfarçado de
orientado a objeto"

> "pensar no projeto de
classes, em como elas se encaixam e como elas serão estendidas é o
que importa."

> "aprender e a escrever softwares ainda melhores."

- Capítulo II - A COESÃO E O TAL DO SRP

[Decorator](https://refactoring.guru/pt-br/design-patterns/decorator)

[Decorator em PHP](https://refactoring.guru/pt-br/design-patterns/decorator/php/example)

> "Design Patterns com Java: Projeto
orientado a objetos guiado por padrões"

> "ARQUITETURA HEXAGONAL"

> "Classes coesas são mais fáceis de serem mantidas, reutilizadas e
tendem a ter menos bugs. Pense nisso."

> "Coesão é fundamental, mas acoplamento também. Essa é uma
balança interessante. Falaremos mais sobre o assunto no próximo
capítulo."

[Design Patterns in PHP](https://github.com/gabrielanhaia/php-design-patterns)

[Resumo do capítulo 1 e 2](app/capitulo1-2/resumo_capitulos_1_e_2_oo_e_srp.md)

[Exemplos de código](app/capitulo1-2/index.php)

- Capítulo III - ACOPLAMENTO E O TAL DO DIP

> "tenha classes que são muito coesas e pouco acopladas"

> "problema do acoplamento é que uma mudança em qualquer uma das classes pode impactar em mudanças na classe principal"

> "a partir do momento em que uma classe possui muitas dependências, todas elas podem propagar problemas para a classe principal."

> "modelaremos nossos sistemas fugindo dos acoplamentos perigosos"

> "dependência é estável"

> "acoplar-se a classes, interfaces, módulos, que sejam estáveis, que tendam a mudar muito pouco"

> "interfaces possuem um papel muito importante em sistemas orientados a objetos"

> "padrões de projeto ajudam você a desacoplar seus projetos de classe"

> "Módulos de alto nível não devem depender de módulos de baixo nível. Ambos devem depender de abstrações"

> "Abstrações não devem depender de detalhes. Detalhes devem depender de abstrações"

> "Princípio de Inversão de Dependência"

> "solução é pensar não só no acoplamento, mas também em divisão de responsabilidades"

> "acoplamento lógico pode nos indicar um mau projeto de classes, ou mesmo código que não está bem encapsulado"

[Resumo do capítulo 3](app/capitulo3/resumo_capitulo3-dip.md)

[Exemplos de código](app/capitulo3/exemplos_em_php_capitulo_3_acoplamento_e_dip.md)

[Um pouco mais sobre DIP](app/capitulo3/dip.md)

- Capítulo IV - CLASSES ABERTAS E O TAL DO OCP

> "nosso código deve estar sempre pronto para evoluir"

> "a discussão o tempo inteiro é sobre como balancear entre acoplamento e coesão. Buscar esse equilíbrio é fundamental!"

> "Precisamos fazer com que a criação de novas regras seja mais simples, e que essa mudança propague automaticamente por todo o sistema."

> "abertas para extensão, mas fechadas para modificação"

> "solução é deixar de instanciar as implementações concretas dentro dessa classe, e passar a recebê-las pelo construtor"

> "Pensar em abstrações nos ajuda a resolver o problema do acoplamento e, de quebra, ainda nos ajuda a ter códigos facilmente extensíveis."

> "se está difícil de testar, é porque seu código pode ser melhorado"

> "sistemas OO evoluem por meio de novos códigos, e não de alterações em códigos já existentes"

[Resumo do capítulo 4](app/capitulo4/resumo_capitulo4-ocp.md)

[Exemplos de código](app/capitulo4/exemplos_em_php_capitulo_4_ocp.md)

[Um pouco mais sobre OCP](app/capitulo4/ocp_arquitetura_hexagonal_e_clean_architecture.md)

- Capítulo V - O ENCAPSULAMENTO E A PROPAGAÇÃO DE MUDANÇAS

> "Falta ainda um grande pilar, que é encapsulamento"

> "Encapsulamento é o nome que damos à ideia de a classe esconder os detalhes de implementação, ou seja, como o método faz o trabalho dele."

> "dois ganhos: facilidade para alterar a implementação e termos a regra de negócio espalhada por lugares diferentes"

> "sempre que a regra de negócio mudar, essa mudança deverá ser propagada em muitos lugares diferentes"

> "Uma classe (ou método) bem encapsulada é aquela que esconde bem a maneira como faz as coisas"

> "intimidade inapropriada"

> "que entendem mais do que deveriam sobre o comportamento de uma outra classe"

> "Tell, Don’t Ask"

> "devemos sempre dizer ao objeto o que ele tem de fazer, e não primeiro perguntar algo a ele, para depois decidir"

> "No mundo OO, devemos o tempo todo dar ordens aos objetos."

> "programar OO é não pensar só na implementação daquela classe, mas também nas classes clientes, que a consumirão"

> "Lei de Demeter"

> "sugere que evitemos o uso de invocações em cadeia"

> "lembre-se de não criar getters e setters: sem pensar. Eles precisam de um motivo para existir"

> "Como que eu sei que as minhas classes e métodos estão encapsulados? Basta olhar para ela e tentar responder as duas perguntas: O quê? E como? O "o quê?" você tem de ser apaz de responder, porque o nome do método tem de lhe dizer isso. O "como?" você não tem de conseguir responder."

> "pensar em um projeto de classe é desafiador"

> "encapsulamento. Esconda os detalhes da implementação, e diminua pontos de mudança"

> "Seu sistema deve ser idêntico: se você tocar em uma classe, você precisa ver facilmente as outras classes que deverão ser alteradas."

[Resumo do capítulo 5](app/capitulo5/capitulo_v_resumo.md)

[Over Encapsulation](app/capitulo5/over_encapsulation.md)

- Capítulo VI - HERANÇA X COMPOSIÇÃO E O TAL DO LSP

> "No começo das linguagens orientadas a objeto, a herança era a funcionalidade usada para vender a ideia."

> "classes filhas precisam respeitar os contratos definidos pela classe pai"

> "Para usar herança de maneira adequada, o desenvolvedor deve pensar o tempo todo nas pré e pós-condições que a classe pai definiu."

> "Toda classe ou método tem as suas pré e pós-condições."

> "A classe filho só pode afrouxar a precondição."

> "a pós-condição só pode ser apertada"

> "É sobre isso que o Princípio de Substituição de Liskov discute."

> "Sempre que uma classe depende da outra para existir, é acoplamento."

> "ao pensar em modelar hierarquias de classe usando herança, lembre-se do acoplamento entre classe pai e filho"

> "tentar ao máximo reduzir o acoplamento entre a classe pai e a classe filho"

> "uso de composição em vez de herança."

> "Escrever testes automatizados também é mais fácil. Mockar objetos e comportamentos e passá-los para classes que as usam para compor o comportamento é natural; com herança, muito mais difícil."

> "às vezes fazemos uma "má herança" para termos outros ganhos"

> "você modela a classe para usar herança, ou não. Herança deve ser usada quando existe realmente a relação de X é um Y"

> "Não use herança caso a relação seja de composição, ou seja, X tem um Y, ou X faz uso de Y."

> "Um conjunto de classes que fazem bom uso de herança seguem os princípios discutidos anteriormente. Eles evitam ao máximo que a classe filho conheça detalhes da implementação do pai, e não violam as restrições de pré e pós-condições na hora de sobrescrever um determinado comportamento."

> "Use herança para reaproveitar código que realmente faz sentido, e composição para trechos de código que precisam de mais flexibilidade."

> "Pacotes são a maneira que temos para agrupar classes que são parecidas."

> "deixe perto coisas que se relacionam e mudam juntas"

> "Não descarte herança, apenas favoreça a composição."

[Resumo do capítulo 6](app/capitulo6/resumo_capitulo6-heranca_vs_composicao_lsp.md)

[Herança na Clean Architecture e Hexagonal](app/capitulo6/heranca_na_clean_architecture_e_hexagonal.md)

- Capítulo VII - INTERFACES MAGRAS E O TAL DO ISP

> "coesão é fundamental para manutenção e reúso de nosso código"

> "interface "gorda" (do inglês, fat interface)"

> "A solução para o problema é análoga ao que tomamos quando discutimos classes coesas. Se uma classe não é coesa, dividimo-la em duas ou mais classes; se uma interface não é coesa, também a dividimos em duas ou mais interfaces."

> "interfaces coesas são aquelas que possuem também apenas uma única responsabilidade."

> "Quanto mais simples, menos problemas."

> "Classes que dependem de interfaces leves sofrem menos com mudanças em outros pontos do sistema."
 
> "Fazer com o que o cliente não precise depender (se acoplar) de coisas das quais ele não precisa é justamente a ideia por trás do ISP (Interface Segregation Principle) ou, em português, Princípio da Segregação de Interface."

> "lembrar de separar infraestrutura do resto"

> "Interfaces são fundamentais em bons sistemas orientados a objetos. Tomar conta delas é importante."

> "acoplamento, coesão, simplicidade e encapsulamento fazem sentido não só para classes concretas, mas sim para tudo"

[Resumo do capítulo 7](app/capitulo7/capitulo_7_isp.md)

- Capítulo VIII - CONSISTÊNCIA, OBJETINHOS E OBJETÕES

> "consistência do objeto"

> "Preciso de objetos para representar um CPF, ou uma simples resolve? Quais os problemas de ter objetos em estados String inválidos? Como validar esse estado? Como garantir consistência dos objetos de domínio?"

> "Objetos em estado inválido são bastante problemáticos. Por estado inválido, entenda-se aquele objeto cujos atributos possuem valores não aceitáveis."

> "Garantir a integridade do seu estado é responsabilidade do próprio objeto."

> "Construtores são uma ótima maneira de se resolver esse problema."

> "Se você tem objetos que são complicados de serem criados e um simples construtor não resolve, você pode apelar para padrões de projeto criacionais, como é o caso do Builder ou da Factory."

> "Lembre-se também de que a própria classe deve garantir que fique em um estado válido para sempre."

> "Garanta consistência dos seus objetos. Use construtores. Novamente, se seu objeto possui atributos necessários desde o primeiro momento, não permita que o objeto seja criado sem eles."

> "validação em dois tipos diferentes: primeiro, aquele conjunto de validações para garantir que o tipo de dado enviado pelo usuário seja válido."

> "segundo lugar, validações de negócio, ou seja, que determinado imposto precisa ser maior que 1%, ou que pessoas físicas precisam de um CPF."

> "Você não deve permitir que dados sujos cheguem ao seu domínio."

> "Esse tipo de discussão é bastante comum em arquiteturas hexagonais. Projetistas que gostam dessa linha de raciocínio preferem deixar toda essa validação simples de dados nos "adaptadores". Já as regras de validação que envolvem negócio, dentro das "portas"."

> "se suas regras de validação são complexas, partir para uma solução mais flexível é necessário; se elas forem simples, talvez deixá-las puramente em seus controladores seja suficiente."

> "o que seria do mundo se ninguém nunca passasse nulo para sua classe?"

> "pense em usar Null Objects, ou algo parecido"

> "Classes como essa, que representam uma pequena parte do nosso sistema e praticamente não têm comportamentos, são conhecidas por tiny types."

> "Tiny types são interessantes e nos ajudam a ter um código mais flexível, reusável e fácil de manter. Mas também podem complicar trechos de código que seriam por natureza  simples."

> "Desenvolvedores odeiam DTOs; ponto final."

> "DTOs, como o próprio nome diz, são Data Transfer Objects."

> "Não tenha medo de criar DTOs que representem pedaços do seu sistema. Facilite a transferência de dados entre suas camadas; aumente a semântica deles. Lembre-se de que o problema não é ter DTOs, mas sim só ter DTOs."

> "Alterar o estado da classe pode ser um problema justamente porque você não sabe se o estado dela foi alterado em algum lugar, então seu programa não está esperando uma alteração nela."

> "Escrever uma classe imutável não é complicado."

> "se você precisar dar um método que modifica o conteúdo do objeto, esse objeto deve devolver uma nova instância dessa classe, com o novo valor."

> "Imutabilidade tem lá suas vantagens, mas também não é bala de prata. O projetista deve encontrar os melhores lugares para usar a técnica."

> "Código limpo sempre."

> "Nomenclatura é outro detalhe importante em sistemas OO. É por meio dos nomes que damos às coisas, como classes, pacotes, métodos e atributos, que conseguimos entender o significado de cada um deles."

> "A vantagem da convenção da linguagem é que qualquer desenvolvedor do planeta a entende"

> "A regra é que não há regra. Apenas reflita bastante sobre os nomes escolhidos. Eles é que são responsáveis pela semântica do seu projeto de classes."

> "Validação, imutabilidade, tiny types etc. têm seu espaço e fazem sentido em muitos casos."

> "não parar por aqui e continuar a estudar o conjunto de boas práticas contextuais que existe para a combinação linguagem-framework-domínio em que você atua"

[Resumo do capítulo 8](app/capitulo8/capitulo_8_consistencia_objetinhos_e_objetoes.md)

[Exemplos de codigo](app/capitulo8/exemplo-completo_PHP-Laravel.md)

[Guia pratico](app/capitulo8/guia-pratico.md)

[Diagra Arquitetural](app/capitulo8/diagrama-arquitetural.md)

- Capítulo IX - MAUS CHEIROS DE DESIGN

> ""más práticas" é conhecido por smells (do inglês, mau cheiro)"

> "Refused Bequest é o nome dado para quando herdamos de uma classe, mas não queremos fazer uso de alguns dos métodos herdados."

> "Feature Envy é o nome que damos para quando um método está mais interessado em outro objeto do que no objeto em que ele está inserido."

> "Às vezes, o comportamento está no lugar errado. Pergunte a você mesmo se ele não poderia estar dentro da classe que aquele método está usando."

> "intimidade inapropriada"

> "Procure sempre colocar comportamentos nos lugares corretos, e não deixe suas abstrações vazarem. Encapsulamento é fundamental."

> "Uma god class é aquela classe que controla muitos outros objetos do sistema."

> "Divergent changes é o nome do mau cheiro para quando a classe não é coesa, e sofre alterações constantes, devido às suas diversas responsabilidades."

> "shotgun surgery"

> "além de estudar e ler sobre boas práticas, leia também sobre maus cheiros"

[Resumo do capítulo 9](app/capitulo4/resumo_capitulo4-ocp.md)

[Agile Principles, Patterns and Practices in C#](app/capitulo4/ocp_arquitetura_hexagonal_e_clean_architecture.md)