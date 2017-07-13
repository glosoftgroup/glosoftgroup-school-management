<div class="head">
            <thead>
                <tr>
                    <td align="center"><input type="checkbox" class="checkall" /></td>
                    <th>Title</th>											
                    <th>Slug</th>
                    <th><span>Description</span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): $user=$this->ion_auth->get_user($post->created_by);?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $post->id); ?></td>
                        <td><?php echo $post->title ?></td>											
                    </tr>
                <?php endforeach; ?>
            </tbody>
         
        </table>
        <div class="left">
            <button type="submit" name="btnAction" value="delete" class="btn btn-danger">Delete</button>
            <button type="submit" name="btnAction" value="publish" class="btn btn-warning">Publish</button>

        </div>
        <?php echo form_close(); ?>    
  
  </div><!--/span-->