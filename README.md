##Yaf Codes Generator

###Usage
```
php yaf_cg.php Sample
```

will generator folder "Sample" under output:
```
$ ls output/Sample/
app/ public/
```

The sample template contains:

    bootstrap sample
    
    router sample
    
    controller sample
    
    orm sample(provide by 张洋)
    
    layout sample(provide by Andreas Kollaros)
    
    
You may need to modify the template to suit your needs.

update 2014-10-20:

    fix generate method . if yaf.user_namespace=Off ,gen nonamespace code .
    
    