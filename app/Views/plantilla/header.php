<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $titulo ?? 'Cocineritos' ?></title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

  <link rel="stylesheet" href="<?= base_url('assets/css/miestilo.css') ?>">

  <style>
        #navbarCocineritos {
            transition: transform 0.3s ease-in-out; /* movimiento del navbar */
        }
        .nav-oculto {
            transform: translateY(-100%); /* Lo empuja hacia arriba */
        }
    </style>
</head>
 
   

<body>