<div class="container-pagination">
    <?php if ($total_page > 0): ?>
        <ul class="custom pagination">
            <?php if ($page > 1): ?>
                <li>
                    <a href="<?php echo $back_link; ?>" aria-label="Previous">
                                <span aria-hidden="true">
                                    <span class="text-pagination-arrow previous">⟵</span>
                                    Previous
                                </span>
                    </a>
                </li>
            <?php endif; ?>
            <?php foreach ($page_lists as $plist): ?>
                <?php if (array_get($plist, "value", "") === "..."): ?>
                    <li><a href="javascript:void(0);"><span class="text-pagination-more">...</span></a></li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo array_get($plist, "link", "#"); ?>" class="<?php echo array_get($plist, "class", ""); ?>">
                            <?php echo array_get($plist, "value", ""); ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($page < $total_page): ?>
                <li>
                    <a href="<?php echo $next_link; ?>" aria-label="Next">
                            <span aria-hidden="true">Next
                                <span class="text-pagination-arrow next">⟶</span>
                            </span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</div>