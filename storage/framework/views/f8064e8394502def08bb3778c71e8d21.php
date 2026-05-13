<?php if($paginator->hasPages()): ?>
    <div class="custom-pagination">
        
        
        <div class="pagination-buttons">
            
            <?php if($paginator->onFirstPage()): ?>
                <span class="pagination-btn disabled">←</span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="pagination-btn">←</a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span class="pagination-btn page active"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" class="pagination-btn page"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="pagination-btn">→</a>
            <?php else: ?>
                <span class="pagination-btn disabled">→</span>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/vendor/pagination/my-pagination.blade.php ENDPATH**/ ?>