<?php
// tests/SimpleTest.php - 最低限テスト（2つだけ）
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testHtmlEscape(): void
    {
        // セキュリティ基本：HTMLエスケープテスト
        $dangerous = '<script>alert("hack")</script>';
        $safe = htmlspecialchars($dangerous);
        $this->assertStringContainsString('&lt;script&gt;', $safe);
        $this->assertStringNotContainsString('<script>', $safe);
    }

    public function testFileOperation(): void
    {
        // 基本機能：ファイル読み書きテスト
        $test_file = '/tmp/test.txt';
        $test_data = "10:30 - Hello\n10:31 - World";
        
        file_put_contents($test_file, $test_data);
        $this->assertFileExists($test_file);
        
        $content = file_get_contents($test_file);
        $messages = explode("\n", trim($content));
        $this->assertCount(2, $messages);
        $this->assertEquals('10:30 - Hello', $messages[0]);
        
        unlink($test_file);
    }
}