<?php

class Brand extends Dbh {
    // Method to add a new brand with name and description (brandId removed)
    protected function addBrand($brandName, $description = null) {
        $sql = "INSERT INTO brand (brand_name, description) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName, $description]);
    }
    
    // Method to get a brand by ID
    protected function getBrandById($brandId) {
        $sql = "SELECT * FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
        return $stmt->fetch();
    }
    public function getBrandByModelId($modelId) {
        $sql = "SELECT b.brand_name
            FROM brand b
            INNER JOIN model m ON b.brand_name = m.brand
            WHERE m.model_id = ?";
        // $sql = "SELECT * FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
        return $stmt->fetch();
    }

    // Method to get all brands
    protected function getAllBrands() {
        $sql = "SELECT * FROM brand";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Method to update brand name
    protected function updateBrandName($brandId, $brandName) {
        $sql = "UPDATE brand SET brand_name = ? WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName, $brandId]);
    }

    // Method to update brand description
    protected function updateBrandDescription($brandId, $description) {
        $sql = "UPDATE brand SET description = ? WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$description, $brandId]);
    }

    // Method to update brand quantity
    public function updateBrandQuantity($brandName) {
        // Sum the quantity of all brands belonging to this brand
        $sql = "SELECT SUM(quantity) AS total_quantity FROM model WHERE brand = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName]);
        $totalQuantity = $stmt->fetchColumn();

        // Update the brand's quantity
        $sqlUpdate = "UPDATE brand SET quantity = ? WHERE brand_name = ?";
        $stmtUpdate = $this->connect()->prepare($sqlUpdate);
        $stmtUpdate->execute([$totalQuantity, $brandName]);
    }

    // Method to delete a brand by ID
    protected function deleteBrand($brandId) {
        $sql = "DELETE FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
    }
}

class BrandCtrl extends Brand {
    // Create a new brand
    public function createBrand($brandName, $description) {
        if (empty($brandName)) {
            throw new Exception("Brand name is required.");
        }

        $this->addBrand($brandName, $description);
    }

    // Update brand name
    public function setBrandName($brandId, $brandName) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }
        if (empty($brandName)) {
            throw new Exception("Brand name is required.");
        }

        $this->updateBrandName($brandId, $brandName);
    }

    // Update brand description
    public function setBrandDescription($brandId, $description) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }

        $this->updateBrandDescription($brandId, $description);
    }

    // Update brand quantity
    public function setBrandQuantity($brandId, $quantity) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        } else {
            $sql = "UPDATE brand SET quantity = :qty WHERE brand_id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([":qty" => $quantity, ":id" => $brandId]);
        }
    }

    // Delete a brand
    public function deleteBrand($brandId) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }

        $this->deleteBrand($brandId);
    }

    // Get all brands
    public function getAllBrands() {
        return parent::getAllBrands(); // Call the method from the Brand model class
    }

    // In BrandCtrl class
    public function getBrandsWithQuantities($searchQuery = '', $sortOrder = 'brand_asc', $storeId = null) {
        // Start with base query selecting brands (distinct)
        $query = "SELECT DISTINCT brand FROM model WHERE brand IS NOT NULL";
        $params = [];

        // Apply search conditions if searchQuery is provided
        if (!empty($searchQuery)) {
            $query .= " AND brand LIKE :searchQuery";
            $params[':searchQuery'] = '%' . $searchQuery . '%';
        }

        // Apply sorting
        switch ($sortOrder) {
            case 'brand_asc':
                $query .= " ORDER BY brand ASC";
                break;
            case 'brand_desc':
                $query .= " ORDER BY brand DESC";
                break;
            default:
                $query .= " ORDER BY brand ASC";
        }

        // Prepare and execute the query to get brands
        $stmt = $this->connect()->prepare($query);
        $stmt->execute($params);
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process brands to calculate the total quantity in each brand
        $validBrands = [];
        foreach ($brands as &$brand) {
            $brandName = $brand['brand'];

            $sql2 = "SELECT * FROM brand WHERE brand_name = :cname";
            $stmt2 = $this->connect()->prepare($sql2);
            $stmt2->execute([":cname" => $brandName]);
            $validBrand = $stmt2->fetch(PDO::FETCH_ASSOC);

            $quantity = $this->getQuantityInBrand($brandName, $storeId);


            if ($quantity > 0) {
                $validBrand['quantity'] = $quantity;
                $validBrands[] = $validBrand;
            }

        }

        return $validBrands;
    }

    public function getQuantityInBrand($brandName, $storeId) {
        // Sum the quantity of models that belong to this brand in the specified store
        $query = "SELECT COUNT(*) AS total_quantity
                FROM equipment e
                JOIN model m ON e.model_id = m.model_id
                WHERE m.brand = :brandName";
        
        if ($storeId !== null) {
            $query .= " AND e.store_id = :storeId";
        }
        
        $stmt = $this->connect()->prepare($query);
        $params = [':brandName' => $brandName];
        if ($storeId !== null) {
            $params[':storeId'] = $storeId;
        }
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_quantity'] ?? 0; // Default to 0 if no result
    }


    // Get a single brand by ID
    public function getBrandById($brandId) {
        return parent::getBrandById($brandId); 
    }


    // Update the quantity of a brand based on models associated with it
    public function updateBrandQuantityFromModels($brandId) {
        // Sum the quantity of all models belonging to this brand
        $sql = "SELECT SUM(quantity) AS total_quantity FROM model WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
        $totalQuantity = $stmt->fetchColumn();

        // Update the brand's quantity
        $sqlUpdate = "UPDATE brand SET quantity = ? WHERE brand_id = ?";
        $stmtUpdate = $this->connect()->prepare($sqlUpdate);
        $stmtUpdate->execute([$totalQuantity, $brandId]);
    }
}
