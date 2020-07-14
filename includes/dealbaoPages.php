<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/17
 * Time: 13:51
 */

class dealbaoPages
{
    protected $prevPage;//上一页
    protected $nextPage;//下一页
    protected $firstPage;//首页
    protected $lastPage;//最后一页
    protected $page;//当前页码
    protected $totalPage;//总共页
    protected $type; //页面分页位置， 1上2下
    protected $total;//总数

    public function __construct($page, $totalPage, $type, $total)
    {
        $this->page = $page;
        $this->totalPage = $totalPage;
        $this->type = $type;
        $this->total = $total;
    }

    public function pagesHtml()
    {
        $html = '';
        $html .= ' <div class="tablenav-pages"><span class="displaying-num">'.$this->total.' '.__('Projects','dealbao').'</span>
            <span class="pagination-links">';
        if ($this->page > 1) {
            $html .= $this->firstPageHtml();
            $html .= $this->prevPageHtml();
        }else{
            $html .= ' <span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin: 2px">«</span>';
            $html .= '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin: 2px">‹</span>';

        }

        $html .= '<span class="paging-input" style="margin: 2px">'.__('No','dealbao').'.<label for="current-page-selector" class="screen-reader-text">'.__('Current page','dealbao').'</label>
<input class="current-page" id="current-page-selector'.$this->type.'" type="text" name="paged" value="'.($this->page).'" onkeydown="keyup_submit(event,\'newpage'.$this->type.'\');"  onblur="dealbaoPages(\'newpage'.$this->type.'\')" size="1" aria-describedby="table-paging">
<span class="tablenav-paging-text">'.__('Page','dealbao').'，'.__('Total','dealbao').' <span class="total-pages">'.$this->totalPage.'</span>'.__('Page','dealbao').'</span></span>';



        if ($this->page < $this->totalPage) {
            $html .= $this->nextPageHtml();
            $html .= $this->lastPageHtml();
        }else{

            $html .= '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin: 2px">›</span>';
            $html .= ' <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin: 2px">»</span>';
        }
        $html .= '</span></div>';
//        $html .= '<span class="pageNumber">共' . $this->totalPage . '页</span>';

        return $html;
    }


    //生成上一页
    public function prevPageHtml()
    {
        return $this->prevPage = '<a class="prev-page button"  href="javascript:;" onclick="dealbaoPages('.($this->page - 1).')" style="margin: 2px"><span class="screen-reader-text">'.__('Previous Page','dealbao').'</span><span aria-hidden="true">‹</span></a>';
    }

    //生成下一页
    public function nextPageHtml()
    {


        return $this->nextPage = '<a class="next-page button"  href="javascript:;" onclick="dealbaoPages('.($this->page + 1).')" style="margin: 2px"><span class="screen-reader-text">'.__('Next Page','dealbao').'</span><span aria-hidden="true">›</span></a>';
    }

    //生成首页
    public function firstPageHtml()
    {
        return $this->firstPage = '<a class="first-page button"  href="javascript:;" onclick="dealbaoPages(1)" style="margin: 2px"><span class="screen-reader-text">'.__('Home Page','dealbao').'</span><span aria-hidden="true">«</span></a>';
    }

    //生成跳转尾页
    public function lastPageHtml()
    {

        return $this->lastPage = '<a class="last-page button"  href="javascript:;" onclick="dealbaoPages('.$this->totalPage.')" style="margin: 2px"><span class="screen-reader-text">'.__('Trailer Page','dealbao').'</span><span aria-hidden="true">»</span></a>';
    }
}