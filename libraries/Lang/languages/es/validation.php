<?php
return [
  'required'  => 'El :field campo es requerido',
  'min'       => [
    'string'  => 'El :field debe tener al menos :min caracteres.'
  ],
  'equalTo'   => 'El :field campo y :fieldToCompare campo deben coincidir.',
  'email'     => 'El :field campo debe ser un correo electrónico válido.',
  'numeric'   => 'El :field campo debe ser un número',
  'size'      => 'El :field campo debe tener :size dígitos.',
  'max'       => 'El :field campo no puede tener más de :max caracteres.',
  'in'        => 'El :field seleccionado es inválido.',
];
?>