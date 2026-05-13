<div class="learn-all-row">
    <?php if(isset($collection) && $collection): ?>
        <a href="<?php echo e(route('learning.collection.show', [$collection, $characters->first()])); ?>" class="learn-all-btn">
            Начать изучение первого иероглифа
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('learning.show', $characters->first() ?? 1)); ?>" class="learn-all-btn">
            Начать изучение первого иероглифа
        </a>
    <?php endif; ?>
</div>

<div class="characters-grid" id="charactersGrid">
    <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isLearned = in_array($character->id, $learnedCharacterIds);
        ?>
        <div
           class="character-card <?php echo e($isLearned ? 'learned' : ''); ?>"
           data-pinyin="<?php echo e(strtolower($character->pinyin)); ?>"
           data-meaning="<?php echo e(strtolower($character->meaning)); ?>">
            <div class="character-char"><?php echo e($character->character); ?></div>
            <div class="character-pinyin"><?php echo e($character->pinyin); ?></div>
            <div class="character-meaning"><?php echo e($character->meaning); ?></div>
        
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if($characters->hasPages()): ?>
    <div class="pagination" data-level-pagination>
        <?php echo e($characters->links('vendor.pagination.my-pagination')); ?>

    </div>
<?php endif; ?>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/learning/partials/level-characters.blade.php ENDPATH**/ ?>