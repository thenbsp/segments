### cascade={"remove"}

the entity on the inverse side is deleted when the owning side entity is. Even if you are in a manytomany with other owning side entity.

- should be used on collection (so in OneToMany or ManyToMany relationship)
- implementation in the ORM

> a 和 b 是一对多关系，删除 a 一行记录时，b 相关的记录会被删除

### orphanRemoval=true

the entity on the inverse side is deleted when the owning side entity is AND it is not connected to any other owning side entity anymore. (ref. doctrine official_doc - implementation in the ORM

- can be used with OneToOne, OnetoMany or ManyToMany

> a 和 b 是一对多关系，在 a 实体中通过 a->removeXxx(b) 后，保存 a，则 b 记录中被 RemoveXxx(b) 部分会被删除

### onDelete="CASCADE"

this will add On Delete Cascade to the foreign key column in the database

- This strategy is a bit tricky to get right but can be very powerful and fast. (ref. doctrine official_doc ... but haven't read more explainations)
- ORM has to do less work (compared to the two previous way of doing) and therefore should have better performance.

http://stackoverflow.com/questions/27472538/cascade-remove-vs-orphanremoval-true-vs-ondelete-cascade
