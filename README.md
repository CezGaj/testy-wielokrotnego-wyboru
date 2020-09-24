Po pobraniu wszystkich plików na serwer, należy jeszcze skonfigurować bazę danych MySQL uruchamiając plik <b>database.sql</b>

Możesz dodawać, modyfikować i usuwać własne testy. Skrypt odpowiadający za testy zakłada, że każde pytanie zawiera 4 możliwe odpowiedzi, z czego conajmniej
jedna jest prawidłowa.
1. Tworzysz plik tekstowy we folderze <b>testy</b>, najlepiej wykorzystując edytor pokroju <b>notepad++</b> w którym widać numery linii.
2. Numery linii są przydatne, dla prawidłowego działania skryptu. Żeby użyć równania matematycznego należy napisać formułę w MathJax (przykładowy plik matura.txt opisuje
jak to powinno wyglądać). Prawidłowa postać pliku tekstowego wygląda następująco:
  - 1. linijka zawiera pytanie
  - od 2 do 5 linijki znajdują się możliwe odpowiedzi [A,B,C,D]
  - 6. linijka zawiera prawidłowe odpowiedzi zapisywane kolejnością rosnącą np. AC
Skrypt generuje pytania z pliku dopóki plik się nie skończy, nie ma ograniczenia liczby pytań, lecz prawidłowy plik zawiera liczbę linii podzielną przez 6. <b>Należy zwracać uwagę, 
żeby nie było pustej linii na końcu.</b>
3. Po skończeniu trzeba jeszcze skonfigurować utworzony test w pliku <b>config.txt</b> w głównym folderze.
  - 1. linijka zawiera hasło do testu zaszyfrowane md5
  - 2. linijka zawiera położenie pliku np. <b>testy/matura.txt</b>
  - 3. linijka określa czy punktacja jest 0-1 czy 0-0.5-1
  - 4. linijka określa czy test jest jednokrotnego czy wielokrotnego wyboru
  - 5. linijka określa ograniczenie czasowe wykonywania testu (liczba całkowita minut)
Skrypt sprawdza czy hasło jest prawidłowe przeskakując co 5 linijek, jeśli jest prawidłowe to odczytywane są kolejne linijki w celu konfiguracji testu.
