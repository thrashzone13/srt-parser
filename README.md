# Srt Parser
Tiny library for parsing srt files.

```
$parser = new Thrashzone13\SrtParser\SrtParser(SRT_FILE_PATH);

$subBlocks = $parser->parse();

foreach($subBlocks as $block){

    echo $block->getNumber();

    echo $block->getText();

    echo $block->getStartTime();

    echo $block->getSTopTime();
    
}