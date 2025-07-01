<?php

class PDFService
{
    public static function generatePetitionResponsePDF($petitionData, $responseContent)
    {
        // PDF içeriği hazırla
        $content = self::preparePDFContent($petitionData, $responseContent);
        
        // HTML to PDF dönüşümü (basit HTML formatı)
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Dilekçe Cevabı</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
                .reference { text-align: right; font-weight: bold; color: #0066cc; margin-bottom: 20px; }
                .content { margin: 20px 0; }
                .footer { margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px; font-size: 12px; }
                .signature { margin-top: 30px; text-align: right; }
                .info-box { background: #f8f9fa; padding: 15px; border-left: 4px solid #0066cc; margin: 20px 0; }
                .info-row { display: flex; justify-content: space-between; margin: 10px 0; }
                .label { font-weight: bold; }
                h1 { color: #0066cc; }
                h2 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
            </style>
        </head>
        <body>
            $content
        </body>
        </html>";
        
        return $html;
    }
    
    public static function generatePetitionResponseWord($petitionData, $responseContent)
    {
        // Word formatı için RTF kullanarak basit bir çözüm
        $content = self::prepareWordContent($petitionData, $responseContent);
        
        $rtf = "{\\rtf1\\ansi\\deff0 {\\fonttbl {\\f0 Times New Roman;}}";
        $rtf .= "{\\colortbl;\\red0\\green102\\blue204;\\red51\\green51\\blue51;}";
        $rtf .= "\\f0\\fs24 $content}";
        
        return $rtf;
    }
    
    private static function preparePDFContent($petitionData, $responseContent)
    {
        $referenceNumber = $petitionData['reference_number'];
        $category = $petitionData['category_name'];
        $priority = $petitionData['priority_name'];
        $date = date('d.m.Y H:i');
        
        return "
        <div class='header'>
            <h1>PROFESYONEl DİLEKÇE MERKEZİ</h1>
            <p>Resmi Dilekçe Cevap Belgesi</p>
        </div>
        
        <div class='reference'>
            Referans No: $referenceNumber<br>
            Tarih: $date
        </div>
        
        <div class='info-box'>
            <h2>Dilekçe Bilgileri</h2>
            <div class='info-row'>
                <span class='label'>Kategori:</span>
                <span>$category</span>
            </div>
            <div class='info-row'>
                <span class='label'>Öncelik:</span>
                <span>$priority</span>
            </div>
            <div class='info-row'>
                <span class='label'>İşlem Tarihi:</span>
                <span>$date</span>
            </div>
        </div>
        
        <div class='content'>
            <h2>Resmi Cevap</h2>
            <p>" . nl2br(htmlspecialchars($responseContent)) . "</p>
        </div>
        
        <div class='signature'>
            <p><strong>Dilekçe Değerlendirme Komisyonu</strong><br>
            Profesyonel Dilekçe Merkezi</p>
        </div>
        
        <div class='footer'>
            <p><em>Bu belge elektronik ortamda oluşturulmuş olup, yasal geçerliliği bulunmaktadır.</em><br>
            <strong>Referans No:</strong> $referenceNumber | <strong>Oluşturma Tarihi:</strong> $date</p>
        </div>";
    }
    
    private static function prepareWordContent($petitionData, $responseContent)
    {
        $referenceNumber = $petitionData['reference_number'];
        $category = $petitionData['category_name'];
        $priority = $petitionData['priority_name'];
        $date = date('d.m.Y H:i');
        
        // RTF formatında içerik hazırla
        $content = "\\par\\pard\\qc\\cf1\\fs28\\b PROFESYONEL DILEKCE MERKEZI\\b0\\par";
        $content .= "\\fs20 Resmi Dilekce Cevap Belgesi\\par\\par";
        
        $content .= "\\pard\\qr\\b Referans No: \\b0 $referenceNumber\\par";
        $content .= "\\b Tarih: \\b0 $date\\par\\par";
        
        $content .= "\\pard\\ql\\b DILEKCE BILGILERI\\b0\\par";
        $content .= "\\b Kategori: \\b0 $category\\par";
        $content .= "\\b Oncelik: \\b0 $priority\\par";
        $content .= "\\b Islem Tarihi: \\b0 $date\\par\\par";
        
        $content .= "\\b RESMI CEVAP\\b0\\par";
        $content .= str_replace("\n", "\\par", $responseContent);
        
        $content .= "\\par\\par\\pard\\qr\\b Dilekce Degerlendirme Komisyonu\\b0\\par";
        $content .= "Profesyonel Dilekce Merkezi\\par\\par";
        
        $content .= "\\pard\\ql\\fs16\\i Bu belge elektronik ortamda olusturulmus olup, yasal gecerliligi bulunmaktadir.\\i0\\par";
        
        return $content;
    }
    
    public static function savePDF($content, $filename)
    {
        $filepath = __DIR__ . '/../../public/downloads/' . $filename;
        
        // HTML içeriğini PDF olarak kaydet (basit metin tabanlı PDF)
        $pdfContent = "%PDF-1.4\n";
        $pdfContent .= "1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n";
        $pdfContent .= "2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n";
        $pdfContent .= "3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Resources<</Font<</F1 4 0 R>>>>/Contents 5 0 R>>endobj\n";
        $pdfContent .= "4 0 obj<</Type/Font/Subtype/Type1/BaseFont/Arial>>endobj\n";
        $pdfContent .= "5 0 obj<</Length " . strlen($content) . ">>stream\n";
        $pdfContent .= "BT /F1 12 Tf 50 750 Td ($content) Tj ET\n";
        $pdfContent .= "endstream endobj\n";
        $pdfContent .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000245 00000 n \n0000000317 00000 n \n";
        $pdfContent .= "trailer<</Size 6/Root 1 0 R>>\nstartxref\n" . strlen($pdfContent) . "\n%%EOF";
        
        file_put_contents($filepath, $pdfContent);
        return $filepath;
    }
    
    public static function saveWord($content, $filename)
    {
        $filepath = __DIR__ . '/../../public/downloads/' . $filename;
        file_put_contents($filepath, $content);
        return $filepath;
    }
    
    public static function createZipArchive($files, $zipFilename)
    {
        $zipPath = __DIR__ . '/../../public/downloads/' . $zipFilename;
        
        // Basit ZIP oluşturma simülasyonu
        $zipContent = "Dilekce ve cevap dosyalari bu arsivde yer almaktadir.\n\n";
        $zipContent .= "Dosyalar:\n";
        foreach ($files as $file) {
            $zipContent .= "- " . basename($file) . "\n";
        }
        
        file_put_contents($zipPath, $zipContent);
        return $zipPath;
    }
}