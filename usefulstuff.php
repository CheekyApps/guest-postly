<?php 

ob_start(); ?>

		

		<div class="<?php echo esc_attr( $classes ); ?>">

			<a href="<?php echo esc_url( $tweet_url ); ?>" class="tweet-link" target="_blank">
				<?php echo $content; ?>
				<span class="ctt-cta">Click to Tweet</span>
			</a>
			
		</div>
		<?php

		$return = ob_get_clean();





 ?>