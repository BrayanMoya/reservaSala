<?php

use Illuminate\Database\Seeder;

class TableEquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    Public function run() {

      $this->command->info('------Equipos en sala id 1');


for ($i=1; $i <= 20; $i++) {
      $equipo = new \reservas\Equipo;
      $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+100);
      $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 301';
      $equipo->SALA_ID = 1;
      $equipo->ESTA_ID = 3;
      $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
      $equipo->save();
      }


for ($i=1; $i <= 24; $i++) {
      $equipo = new \reservas\Equipo;
      $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+200);
      $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 302';
      $equipo->SALA_ID = 2;
      $equipo->ESTA_ID = 3;
      $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
      $equipo->save();
      }


      for ($i=1; $i <= 20; $i++) {
            $equipo = new \reservas\Equipo;
            $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+1200);
            $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 303';
            $equipo->SALA_ID = 3;
            $equipo->ESTA_ID = 3;
            $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
            $equipo->save();
            }

            for ($i=1; $i <= 20; $i++) {
                  $equipo = new \reservas\Equipo;
                  $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+600);
                  $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 306';
                  $equipo->SALA_ID = 6;
                  $equipo->ESTA_ID = 3;
                  $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                  $equipo->save();
                  }

                  for ($i=1; $i <= 25; $i++) {
                        $equipo = new \reservas\Equipo;
                        $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+700);
                        $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 307';
                        $equipo->SALA_ID = 7;
                        $equipo->ESTA_ID = 3;
                        $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                        $equipo->save();
                        }
            for ($i=1; $i <= 26; $i++) {
                  $equipo = new \reservas\Equipo;
                  $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+800);
                  $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 308';
                  $equipo->SALA_ID = 8;
                  $equipo->ESTA_ID = 3;
                  $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                  $equipo->save();
                  }

                  for ($i=1; $i <= 22; $i++) {
                        $equipo = new \reservas\Equipo;
                        $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+900);
                        $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 309';
                        $equipo->SALA_ID = 9;
                        $equipo->ESTA_ID = 3;
                        $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                        $equipo->save();
                        }
        for ($i=1; $i <= 18; $i++) {
              $equipo = new \reservas\Equipo;
              $equipo->EQUI_DESCRIPCION = 'DISENO '.($i+00);
              $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA MAC 310';
              $equipo->SALA_ID = 10;
              $equipo->ESTA_ID = 3;
              $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
              $equipo->save();
              }

              for ($i=1; $i <= 20; $i++) {
                    $equipo = new \reservas\Equipo;
                    $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+1100);
                    $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 311';
                    $equipo->SALA_ID = 11;
                    $equipo->ESTA_ID = 3;
                    $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                    $equipo->save();
                    }
                    for ($i=1; $i <= 20; $i++) {
                          $equipo = new \reservas\Equipo;
                          $equipo->EQUI_DESCRIPCION = 'EQUIPO '.($i+1200);
                          $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 311';
                          $equipo->SALA_ID = 12;
                          $equipo->ESTA_ID = 3;
                          $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                          $equipo->save();
                          }

//Se Estacion 1

for ($i=1; $i <= 20; $i++) {
      $equipo = new \reservas\Equipo;
      $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+10100);
      $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 101';
      $equipo->SALA_ID = 13;
      $equipo->ESTA_ID = 3;
      $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
      $equipo->save();
      }
      for ($i=1; $i <= 18; $i++) {
            $equipo = new \reservas\Equipo;
            $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+10200);
            $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 102';
            $equipo->SALA_ID = 14;
            $equipo->ESTA_ID = 3;
            $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
            $equipo->save();
            }

            for ($i=1; $i <= 20; $i++) {
                  $equipo = new \reservas\Equipo;
                  $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+10300);
                  $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 103';
                  $equipo->SALA_ID = 15;
                  $equipo->ESTA_ID = 3;
                  $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                  $equipo->save();
                  }

                  for ($i=1; $i <= 21; $i++) {
                        $equipo = new \reservas\Equipo;
                        $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+10400);
                        $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 103';
                        $equipo->SALA_ID = 16;
                        $equipo->ESTA_ID = 3;
                        $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                        $equipo->save();
                        }


                        for ($i=1; $i <= 20; $i++) {
                              $equipo = new \reservas\Equipo;
                              $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+20100);
                              $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 201';
                              $equipo->SALA_ID = 18;
                              $equipo->ESTA_ID = 3;
                              $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                              $equipo->save();
                              }

                        for ($i=1; $i <= 20; $i++) {
                              $equipo = new \reservas\Equipo;
                              $equipo->EQUI_DESCRIPCION = 'DISENO '.($i+00);
                              $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA MAC';
                              $equipo->SALA_ID = 19;
                              $equipo->ESTA_ID = 3;
                              $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                              $equipo->save();
                              }


//Se Sede Sur

              for ($i=1; $i <= 25; $i++) {
                    $equipo = new \reservas\Equipo;
                    $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+100).'S';
                    $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 101S';
                    $equipo->SALA_ID = 20;
                    $equipo->ESTA_ID = 3;
                    $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                    $equipo->save();
                    }

                    for ($i=1; $i <= 29; $i++) {
                          $equipo = new \reservas\Equipo;
                          $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+200).'S';
                          $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 102S';
                          $equipo->SALA_ID = 21;
                          $equipo->ESTA_ID = 3;
                          $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                          $equipo->save();
                          }

                          for ($i=1; $i <= 20; $i++) {
                                $equipo = new \reservas\Equipo;
                                $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+300).'S';
                                $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 103S';
                                $equipo->SALA_ID = 22;
                                $equipo->ESTA_ID = 3;
                                $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                                $equipo->save();
                                }

                                for ($i=1; $i <= 20; $i++) {
                                      $equipo = new \reservas\Equipo;
                                      $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+400).'S';
                                      $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 104S';
                                      $equipo->SALA_ID = 23;
                                      $equipo->ESTA_ID = 3;
                                      $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                                      $equipo->save();
                                      }


                            for ($i=1; $i <= 20; $i++) {
                                  $equipo = new \reservas\Equipo;
                                  $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+500).'S';
                                  $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 105S';
                                  $equipo->SALA_ID = 24;
                                  $equipo->ESTA_ID = 3;
                                  $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                                  $equipo->save();
                                  }


                                  for ($i=1; $i <= 22; $i++) {
                                        $equipo = new \reservas\Equipo;
                                        $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+600).'S';
                                        $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA 106S';
                                        $equipo->SALA_ID = 25;
                                        $equipo->ESTA_ID = 3;
                                        $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                                        $equipo->save();
                                        }

                                        for ($i=1; $i <= 20; $i++) {
                                              $equipo = new \reservas\Equipo;
                                              $equipo->EQUI_DESCRIPCION = 'UNIAJC '.($i+700).'S';
                                              $equipo->EQUI_OBSERVACIONES =  'EQUIPOS SALA MAC 107S';
                                              $equipo->SALA_ID = 26;
                                              $equipo->ESTA_ID = 3;
                                              $equipo->EQUI_CREADOPOR =  'USER_PRUEBA';
                                              $equipo->save();
                                              }

  }//FIN function
}//FIN CLASS
