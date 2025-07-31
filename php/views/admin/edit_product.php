<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../partials/swal.php';
require '../../config/connection.php';



// Get product data
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));
$product = pg_fetch_assoc($result);

// Handle form submission

?>

<!-- Main -->
<main class="">
    <div class="contact container" style="padding-bottom:0;">
        <div class="card mb-0">
            <div class="card-header bg-dark text-white">
                <strong>Edit Product</strong>
            </div>
            <div class="card-body">
                <form method="POST" id="editProductForm" action="../../app/edit_product.php">
                        <div class="form-row">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <div class="form-group col-md-6">
                                <label for="product_name">Product Name</label>
                                <input type="text" id="product_name" name="name" class="form-control"
                                    value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cost">Cost Price</label>
                                <input type="number" id="cost" name="cost_price" class="form-control"
                                    value="<?php echo htmlspecialchars($product['cost_price'] ?? ''); ?>"
                                    step="0.01" min="0" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sale_price">Sale Price</label>
                                <input type="number" id="sale_price" name="sale_price" class="form-control"
                                    value="<?php echo htmlspecialchars($product['sale_price'] ?? ''); ?>"
                                    step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="products.php" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left mr-2"></i>Back to Products
                                    </a>
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        Update Product <i class="fa fa-save ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>

        <!-- Product Information -->
        <div class="card mb-0 mt-3">
            <div class="card-header bg-info text-white">
                <strong>Product Information</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Product ID:</strong> <?php echo htmlspecialchars($product['id']); ?></p>
                        <p><strong>Current Cost:</strong> $<?php echo number_format($product['cost_price'], 2); ?></p>
                        <p><strong>Current Sale Price:</strong> $<?php echo number_format($product['sale_price'], 2); ?></p>
                    </div>
                    <div class="col-md-6">
                        <?php
                        $margin = $product['cost_price'] > 0 ? (($product['sale_price'] - $product['cost_price']) / $product['cost_price']) * 100 : 0;
                        $profit = $product['sale_price'] - $product['cost_price'];
                        ?>
                        <p><strong>Profit per Unit:</strong> $<?php echo number_format($profit, 2); ?></p>
                        <p><strong>Profit Margin:</strong> <?php echo number_format($margin, 2); ?>%</p>
                        <p><strong>Created By User ID:</strong> <?php echo htmlspecialchars($product['created_user']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require '../../partials/footer.php'; ?>
</main>

<script>
    // Calculate profit margin in real time
    document.addEventListener('DOMContentLoaded', function() {
        const costInput = document.getElementById('cost');
        const saleInput = document.getElementById('sale_price');

        function updateCalculations() {
            const cost = parseFloat(costInput.value) || 0;
            const sale = parseFloat(saleInput.value) || 0;

            // You could add real-time calculation display here if needed
        }

        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            const name = document.getElementById('product_name').value.trim();
            const cost = parseFloat(document.getElementById('cost').value);
            const sale = parseFloat(document.getElementById('sale_price').value);
            if (!name) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation',
                    text: 'Product name is required.'
                });
                return false;
            }
            if (isNaN(cost) || isNaN(sale) || cost < 0 || sale < 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation',
                    text: 'Prices cannot be negative.'
                });
                return false;
            }
        });

        costInput.addEventListener('input', updateCalculations);
        sale.addEventListener('input', updateCalculations);
    });
</script>

<!-- Main End -->