This is a scraper that runs on [Morph](https://morph.io), and fetches the latest [Unidad de Fomento](http://en.wikipedia.org/wiki/Unidad_de_Fomento) information from [Servicio de Impuestos Internos](http://www.sii.cl)

### Columns 

1. **date:** primary column, date, composition from year-month-day (Y-n-j in [PHP's date() format](http://us1.php.net/manual/en/function.date.php#refsect1-function.date-parameters))
2. **year:** year
3. **month:** month (without leading zero)
4. **day:** day (without leading zero)
5. **value:** the Unidad de Fomento value for that date

### Usage 

*(yes, you can use SQL in Morph!)*

`https://api.morph.io/PotterSys/sii_uf_value/data.json?&query=select%20date%2Cvalue%20from%20%27data%27%20where%20date%3D%222014-10-1%22&key=*YOUR MORPH API KEY*`

Answer:

```
[{
  "date":"2014-10-1",
  "value":"24170.44"
}]
```
