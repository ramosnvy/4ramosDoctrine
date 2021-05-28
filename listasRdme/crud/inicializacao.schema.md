

<h1> O que é um schema?  </h1>
É um recipiente que podem conter vários objetos. São utilizados para gerir e organizar os objetos do banco de dados. 
Você consegue separar logicamente procedures, views, triggers, sequences e etc. Os objetos passam a pertencerem ao schema, 
assim as permissões são aplicadas aos schemas, dessa forma você pode dar permissões para usuários para que eles acessem 
somente os objetos que tem permissão de uma forma mais organizada.

<h2>Inicializando o Schema</h2>

Para criar, devemos ir ao terminal e rodar `vendor\bin\doctrine orm:schema-tool:create,
esse é um dos milhares de comandos presentes no Doctrine. Esse comando deve ser rodado depois das identificações realizadas.