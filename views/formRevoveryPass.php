<?php

$html = '
<h2 class="tl2">Ingrese el codigo de validacion recibido al correo</h2>
<br>
<input class="campos" type="text" id="cod1" maxlength="1" autofocus onkeyup="changeInput(1)">
<input class="campos" type="text" id="cod2" maxlength="1" onkeyup="changeInput(2)">
<input class="campos" type="text" id="cod3" maxlength="1" onkeyup="changeInput(3)">
<input class="campos" type="text" id="cod4" maxlength="1" onkeyup="changeInput(4)">
<input class="campos" type="text" id="cod5" maxlength="1" onkeyup="changeInput(5)">
<input class="campos" type="text" id="cod6" maxlength="1" onkeyup="changeInput(6)">
<br>
<br>
<br>
<input  type="password" name="pass1" id="pass1" class="subs-email" placeholder="Nueva Contraseña">
<br>
<input type="password" name="pass2" id="pass2" class="subs-email" placeholder="Confirmar Contraseña">
<br>
<br>
<button id="btr2" class="subs-send"  onclick="validationPinAndPass()">Enviar Validacion</button>
';