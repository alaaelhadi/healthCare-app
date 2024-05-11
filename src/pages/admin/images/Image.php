<?php
 class Image {
        private $fileName;
        private $tempFileName;
        private $size;
        private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        private $maxSize = 1048576; // 1 GB in bytes
        private $errors = [];
    
        public function __construct(string $fileName, string $tempFileName, string $size) {
            $this->fileName = $fileName;
            $this->tempFileName = $tempFileName;
            $this->size = $size;
        }
    
        public function validate(): bool {
            if ($this->hasImage()) {
            $this->validateExtension();
            $this->validateSize(); 
        }
        return empty($this->errors);
    }

    public function hasImage(): bool {
        return isset($this->fileName) && $this->fileName !== '';
    }
    
        private function validateExtension(): void {
            if ($this->hasImage()) {
            $extension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
            if (!in_array($extension, $this->allowedExtensions)) {
                $this->errors[] = "Invalid file extension. Allowed extensions: " . implode(', ', $this->allowedExtensions);
            }
        }
        }
    
        private function validateSize(): void {

            // var_dump($this->size);
            
            if ($this->hasImage() && $this->size > $this->maxSize) {
                $this->errors[] = "File size exceeds maximum limit of " . round($this->maxSize / 1048576, 2) . " MB.";
            }
        }
    
        public function getErrors(): array {
            return $this->errors;
        }
    
        public function save(string $uploadDir): string {
            if ($this->validate()) {
            
                if (move_uploaded_file($this->tempFileName, $uploadDir)) {
                    return $uploadDir; // Return the saved image path
                } else {
                    $this->errors[] = "Error uploading image.";
                }
            }
            return ""; // Return empty string on error
        }
}

?>