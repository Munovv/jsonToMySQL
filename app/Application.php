<?php

namespace app;

use app\Db\DataBase;

class Application {

                    public $db;
                    public $result;

                    private $table = 'vla_main';
                    private $file  = 'categories.json'; // Для ручной обработки
                    private $children_row;

                    public function __construct(string $row) {
                      // $this->db = new DataBase;      Если требуется вывод json в БД
                         $this->$children_row = $row;
                    }

                    private function jsonToArray(array $data) {
                        foreach($data as $row) {

                          $this->result[$row['id']] = $row;
                          unset($this->result[$row['id'][$this->children_row]]);                                                // Удаляем элемент массива, чтобы не было каши в будущем.

                          if(!empty($row[$this->children_row])) {                                                               // Проверка на наличие дочерних элементов.

                            $this->result[$row['id']][$this->children_row] = '';                                                // Создаем строчный элемент массива, чтобы хранить ID-дочерних элементов, можно использовать и array_push

                            foreach($row[$this->children_row] as $row_2) {
                               $this->result[$row_2['id']] = $row_2;
                               unset($this->result[$row_2['id']][$this->children_row]);                                         // Удаляем элемент массива, чтобы не было каши в будущем.
                               $this->result[$row['id']][$this->children_row] .= '\''.$row_2['id'].'\',';
                            }

                            $this->jsonToArray($row[$this->children_row]);
                            $this->result[$row['id']][$this->children_row] = trim($this->result[$row['id']][$this->children_row], ','); // Удаляем лишнюю запятую на конце.

                          }
                        }
                      ksort($this->result); // Сортируем по ключу [0],[1].....
                      return $this->result;
                    }


                    // private function dump(array $import_data) {      Вывод Json в БД
                    //   foreach ($import_data as $params) {
                    //     $this->db->fastInsert($this->table, $params);
                    //   }
                    // }



                    public function run() {
                      $json = json_decode(file_get_contents($this->file), true);
                      $convert_data = $this->jsonToArray($json);
                      debug($convert_data);
                    }

}

?>
