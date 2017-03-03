AnnotationParser
====

Parse php source code,returns annotations of class and methods

example
---

```php
<?php

use PhpAssist\Doc\AnnotationParser;

        $parser = new AnnotationParser();

        $code = "<?php 
        
        namespace Foo;
        
        /**
        * @class_annotation arg1 arg2
        */
        class Bar
        {
        
            /** @my_annotation arg1
             * */
            public function methodA(){
        
            }
            /** @another_annotation
            */
            public function methodB(){
        
            }
        
        }
        ";

        $result  = $parser ->parse( $code );

        print_r($result);


```


then output is:
```shell
PhpAssist\Doc\AnnotationParseResult Object
(
    [namespace:PhpAssist\Doc\AnnotationParseResult:private] => Foo
    [className:PhpAssist\Doc\AnnotationParseResult:private] => Bar
    [classAnnotations:PhpAssist\Doc\AnnotationParseResult:private] => Array
        (
            [0] => PhpAssist\Doc\Annotation Object
                (
                    [name:PhpAssist\Doc\Annotation:private] => class_annotation
                    [arguments:PhpAssist\Doc\Annotation:private] => Array
                        (
                            [0] => arg1
                            [1] => arg2
                        )

                )

        )

    [methodAnnotationsMapping:PhpAssist\Doc\AnnotationParseResult:private] => Array
        (
            [methodA] => Array
                (
                    [0] => PhpAssist\Doc\Annotation Object
                        (
                            [name:PhpAssist\Doc\Annotation:private] => my_annotation
                            [arguments:PhpAssist\Doc\Annotation:private] => Array
                                (
                                    [0] => arg1
                                )

                        )

                )

            [methodB] => Array
                (
                    [0] => PhpAssist\Doc\Annotation Object
                        (
                            [name:PhpAssist\Doc\Annotation:private] => another_annotation
                            [arguments:PhpAssist\Doc\Annotation:private] => Array
                                (
                                )

                        )

                )

        )

)
```
