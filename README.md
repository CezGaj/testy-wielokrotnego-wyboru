Po pobraniu wszystkich plików na serwer, należy jeszcze skonfigurować bazę danych MySQL uruchamiając plik <b>database.sql</b>

Możesz dodawać, modyfikować i usuwać własne testy. Skrypt odpowiadający za testy zakłada, że każde pytanie zawiera 4 możliwe odpowiedzi, z czego conajmniej
jedna jest prawidłowa.
1. Tworzysz plik tekstowy we folderze <b>testy</b>, najlepiej wykorzystując edytor pokroju <b>notepad++</b> w którym widać numery linii.
2. Numery linii są przydatne, dla prawidłowego działania skryptu. Żeby użyć równania matematycznego należy napisać formułę w MathJax (przykładowy plik matura.txt opisuje
jak to powinno wyglądać). Prawidłowa postać pliku tekstowego wygląda następująco:
  1. linijka zawiera pytanie
  od 2 do 5 linijki znajdują się możliwe odpowiedzi [A,B,C,D]
  6. linijka zawiera prawidłowe odpowiedzi zapisywane kolejnością rosnącą np. AC
Skrypt generuje pytania z pliku dopóki plik się nie skończy, nie ma ograniczenia liczby pytań, lecz prawidłowy plik zawiera liczbę linii podzielną przez 6. <b>Należy zwracać uwagę, 
żeby nie było pustej linii na końcu.</b>
3. Po skończeniu trzeba jeszcze skonfigurować utworzony test w pliku <b>config.csv</b> w głównym folderze.
format jednej linii csv wygladą następująco: <b>hasło md5,nazwa pliku,rodzaj punktacji,rodzaj testu,czas w minutach</b>
przykładowo <b>7f0bf8b062512d71bc3293abca4a964b,so.txt,1,2,10</b>
  rodzaj punktacji: 1 oznacza punktacje 0-0.5-1; 2 oznacza punktacje 0-1
  rodzaj testu: 1 oznacza jednokrotnego wyboru; 2 oznacza wielokrotnego wyboru
