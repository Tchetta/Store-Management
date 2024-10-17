<?php
require_once('../includes/class_autoloader.inc.php');

class Model extends Dbh {
    // Add a new model
    public function createModel($modelName, $brand, $numPorts, $portTypes = '', $quantity = 0, $category, $specification = '', $description = '', $imagePath = 'default.png') {
        $sql = "INSERT INTO model (model_name, brand, number_of_ports, port_types, quantity, category, specification, description, image_path) 
                VALUES (:model_name, :brand, :number_of_ports, :port_types, :quantity, :category, :specification, :description, :image_path)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            'model_name' => $modelName,
            'brand' => $brand,
            'port_types' => $portTypes,
            'quantity' => $quantity,
            'category' => $category,
            'specification' => $specification,
            'description' => $description,
            'image_path' => $imagePath,
            'number_of_ports' => $numPorts
        ]);
    }

    // Get a model by ID
    protected function getModelById($modelId) {
        $sql = "SELECT * FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all models
    protected function getAllModels() {
        $sql = "SELECT * FROM model";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Getters for each column
    protected function getModelName($modelId) {
        $sql = "SELECT model_name FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getNumberOfPorts($modelId) {
        $sql = "SELECT number_of_ports FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getPortTypes($modelId) {
        $sql = "SELECT port_types FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getPowerRating($modelId) {
        $sql = "SELECT power_rating FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getBrand($modelId) {
        $sql = "SELECT brand FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getQuantity($modelId) {
        $sql = "SELECT quantity FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getCategory($modelId) {
        $sql = "SELECT category FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getSpecification($modelId) {
        $sql = "SELECT specification FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getDescription($modelId) {
        $sql = "SELECT description FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getInputCurrent($modelId) {
        $sql = "SELECT input_current FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getInputVoltage($modelId) {
        $sql = "SELECT input_voltage FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getImagePath($modelId) {
        $sql = "SELECT image_path FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    // Setters for each column
    protected function setModelName($modelId, $modelName) {
        $sql = "UPDATE model SET model_name = :model_name WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_name' => $modelName, 'model_id' => $modelId]);
    }

    protected function setNumberOfPorts($modelId, $numberOfPorts) {
        $sql = "UPDATE model SET number_of_ports = :number_of_ports WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['number_of_ports' => $numberOfPorts, 'model_id' => $modelId]);
    }

    protected function setPortTypes($modelId, $portTypes) {
        $sql = "UPDATE model SET port_types = :port_types WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['port_types' => $portTypes, 'model_id' => $modelId]);
    }

    protected function setPowerRating($modelId, $powerRating) {
        $sql = "UPDATE model SET power_rating = :power_rating WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['power_rating' => $powerRating, 'model_id' => $modelId]);
    }

    protected function setBrand($modelId, $brand) {
        $sql = "UPDATE model SET brand = :brand WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['brand' => $brand, 'model_id' => $modelId]);
    }

    protected function setQuantity($modelId, $quantity) {
        $sql = "UPDATE model SET quantity = :quantity WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'model_id' => $modelId]);
    }

    protected function setCategory($modelId, $category) {
        $sql = "UPDATE model SET category = :category WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['category' => $category, 'model_id' => $modelId]);
    }

    protected function setSpecification($modelId, $specification) {
        $sql = "UPDATE model SET specification = :specification WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['specification' => $specification, 'model_id' => $modelId]);
    }

    protected function setDescription($modelId, $description) {
        $sql = "UPDATE model SET description = :description WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['description' => $description, 'model_id' => $modelId]);
    }

    protected function setInputCurrent($modelId, $inputCurrent) {
        $sql = "UPDATE model SET input_current = :input_current WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['input_current' => $inputCurrent, 'model_id' => $modelId]);
    }

    protected function setInputVoltage($modelId, $inputVoltage) {
        $sql = "UPDATE model SET input_voltage = :input_voltage WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['input_voltage' => $inputVoltage, 'model_id' => $modelId]);
    }

    protected function setImagePath($modelId, $imagePath) {
        $sql = "UPDATE model SET image_path = :image_path WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['image_path' => $imagePath, 'model_id' => $modelId]);
    }

    // Delete a model by ID
    protected function deleteModel($modelId) {
        $sql = "DELETE FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
    }

    // Decrease model quantity
    protected function decreaseQuantity($modelName, $quantity) {
        $sql = "UPDATE model SET quantity = quantity - :quantity WHERE model_name = :model_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'model_name' => $modelName]);
    }

    // Increase model quantity
    protected function increaseQuantity($modelName, $quantity) {
        $sql = "UPDATE model SET quantity = quantity + :quantity WHERE model_name = :model_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'model_name' => $modelName]);
    }
}

class ModelCtrl extends Model {
    // Create a new model
    public function createModel($modelName, $brand, $numPorts, $portTypes = '', $quantity = 0, $category, $specification = '', $description = '', $imagePath = 'default.png') {
        // Validate inputs if necessary
        parent::createModel($modelName, $brand, $numPorts, $portTypes, $quantity, $category, $specification, $description, $imagePath);
    }

    // Get all models
    public function getAllModels() {
        return parent::getAllModels();
    }

    // Get model by ID
    public function getModelById($modelId) {
        return parent::getModelById($modelId);
    }

        // Getters
        public function getModelName($modelId) {
            return parent::getModelName($modelId);
        }
    
        public function getNumberOfPorts($modelId) {
            return parent::getNumberOfPorts($modelId);
        }
    
        public function getPortTypes($modelId) {
            return parent::getPortTypes($modelId);
        }
    
        public function getPowerRating($modelId) {
            return parent::getPowerRating($modelId);
        }
    
        public function getBrand($modelId) {
            return parent::getBrand($modelId);
        }
    
        public function getQuantity($modelId) {
            return parent::getQuantity($modelId);
        }
    
        public function getCategory($modelId) {
            return parent::getCategory($modelId);
        }
    
        public function getSpecification($modelId) {
            return parent::getSpecification($modelId);
        }
    
        public function getDescription($modelId) {
            return parent::getDescription($modelId);
        }
    
        public function getInputCurrent($modelId) {
            return parent::getInputCurrent($modelId);
        }
    
        public function getInputVoltage($modelId) {
            return parent::getInputVoltage($modelId);
        }

        public function getImagePath($modelId) {
            return parent::getImagePath($modelId);
        }
    
        // Setters
        public function setModelName($modelId, $modelName) {
            parent::setModelName($modelId, $modelName);
        }
    
        public function setNumberOfPorts($modelId, $numberOfPorts) {
            parent::setNumberOfPorts($modelId, $numberOfPorts);
        }
    
        public function setPortTypes($modelId, $portTypes) {
            parent::setPortTypes($modelId, $portTypes);
        }
    
        public function setPowerRating($modelId, $powerRating) {
            parent::setPowerRating($modelId, $powerRating);
        }
    
        public function setBrand($modelId, $brand) {
            parent::setBrand($modelId, $brand);
        }
    
        public function setQuantity($modelId, $quantity) {
            parent::setQuantity($modelId, $quantity);
        }
    
        public function setCategory($modelId, $category) {
            parent::setCategory($modelId, $category);
        }
    
        public function setSpecification($modelId, $specification) {
            parent::setSpecification($modelId, $specification);
        }
    
        public function setDescription($modelId, $description) {
            parent::setDescription($modelId, $description);
        }
    
        public function setInputCurrent($modelId, $inputCurrent) {
            parent::setInputCurrent($modelId, $inputCurrent);
        }
    
        public function setInputVoltage($modelId, $inputVoltage) {
            parent::setInputVoltage($modelId, $inputVoltage);
        }
    
        public function setImagePath($modelId, $imagePath) {
            parent::setImagePath($modelId, $imagePath);
        }
    
    // Delete a model
    public function deleteModel($modelId) {
        parent::deleteModel($modelId);
    }

    // Decrease model quantity and update brand and category quantities
    public function decreaseQuantity($modelName, $quantity) {
        parent::decreaseQuantity($modelName, $quantity);

        $brandCtrl = new BrandCtrl();
        $categoryCtrl = new ProductCategoryCtrl();

        $brandId = $this->getBrandIdByModel($modelName);
        $categoryId = $this->getCategoryIdByModel($modelName);

        $brandCtrl->updateBrandQuantity($brandId);
        $categoryCtrl->updateCategoryQuantity($categoryId);
    }

    // Increase model quantity
    public function increaseQuantity($modelName, $quantity) {
        parent::increaseQuantity($modelName, $quantity);
    }

    // Get the brand ID associated with a model
    public function getBrandIdByModel($modelId) {
        $sql = "SELECT brand FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    // Get the category ID associated with a model's brand
    public function getCategoryIdByModel($modelId) {
        $brandId = $this->getBrandIdByModel($modelId);
        $brand = new BrandCtrl();
        return $brand->getCategoryIdByBrand($brandId);
    }

    // Paginate models
    public function getModelsByPage($start, $limit) {
        $sql = "SELECT * FROM model LIMIT :start, :limit";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update image path for a model
    public function updateImagePath($modelId, $imagePath) {
        $sql = "UPDATE model SET image_path = :image_path WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':image_path', $imagePath, PDO::PARAM_STR);
        $stmt->bindValue(':model_id', $modelId, PDO::PARAM_INT);
        return $stmt->execute();
    }


    // Get the total number of models for pagination
    public function getTotalModelsCount() {
        $sql = "SELECT COUNT(*) FROM model";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchColumn();
    }

    // Search models by name
    public function searchModelsByName($searchTerm) {
        $sql = "SELECT * FROM model WHERE model_name LIKE :searchTerm";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
